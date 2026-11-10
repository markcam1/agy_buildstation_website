# How SWE-bench Actually Scores AI Models: Under the Hood of the 0% Credit Rule

Every AI coding leaderboard leads with one number: **SWE-bench (% RESOLVED)**. Frontier labs launch models on it. Venture funding decks quote it. Developers debate which LLM writes better code based on it.

Yet most developers assume SWE-bench is an LLM-as-a-judge benchmark or an automated code reviewer grading syntax and stylistic reasoning.

It is not. SWE-bench is a brutal, deterministic integration test executed inside an isolated Docker container against real production repositories.

Here is an architectural walkthrough of how tasks are constructed, how the Docker execution harness grades code, why an AI agent can pass 11 out of 12 tests and still receive **0% credit**, and why the scaffold around the model dictates benchmark scores just as much as the weights themselves.

---

<div class="bs-callout bs-callout-urgent">
  <div class="bs-callout-title" style="color: var(--urgent);">// THE BENCHMARK SPECIFICATION</div>
  <p style="margin: 0; font-family: var(--font-mono); font-size: 14px; line-height: 1.6;">
    <strong>Task Corpus:</strong> 2,294 real historical bugs across 12 open-source Python codebases.<br>
    <strong>Interface Contract:</strong> Raw <code>issue.md</code> + Repo @ <code>base_commit</code> ➔ Single Unified Git Patch (<code>patch.diff</code>).<br>
    <strong>Grading Environment:</strong> 3-tier isolated Docker container running native pytest suites.<br>
    <strong>Scoring Criteria:</strong> 100% of <code>FAIL_TO_PASS</code> tests pass AND 100% of <code>PASS_TO_PASS</code> tests pass. One failed assertion = 0% score.
  </p>
</div>

---

## 1. How a Task Is Made: Information Asymmetry

SWE-bench does not prompt models with synthetic toy problems, LeetCode puzzles, or isolated functions. It draws from real historical pull requests merged by human maintainers across 12 major Python repositories: `django/django`, `sympy/sympy`, `scikit-learn/scikit-learn`, `matplotlib/matplotlib`, `sphinx-doc/sphinx`, `pytest-dev/pytest`, and more.

To build an evaluation task without synthetic bias, the SWE-bench construction pipeline follows four deterministic steps:
1. Identify a merged PR that closes a tracked issue and modifies both codebase modules and unit test files.
2. Check out the repository git tree immediately prior to that PR (`base_commit`).
3. Run the PR's new unit tests against `base_commit`. If the tests fail before the fix and pass after the fix, the bug is verified as reproducible.
4. Package the instance with strict information asymmetry.

<div style="margin: 2.5rem 0; text-align: center;">
  <img src="https://buildstationai.com/wp-content/uploads/2026/11/swebench_01_task_anatomy.png" alt="SWE-bench Task Anatomy & Information Boundary Diagram" style="width: 100%; border-radius: 8px; border: 1px solid var(--grid); display: block;" />
  <p style="font-family: var(--font-mono); font-size: 13px; color: var(--text-dim); margin-top: 12px;">
    Fig 1: The information boundary in SWE-bench. The model is given only two pieces of context; the ground truth remains locked until grading.
  </p>
</div>

Every task instance carries six core fields, divided by an intentional security boundary:

### What the Model Sees (Agent Input)
1. **`issue.md`**: The raw, uncurated issue description posted by an end user on GitHub. These reports are often ambiguous, include messy traceback logs, and lack line-number citations.
2. **`base_commit`**: The repository git tree checked out precisely at the commit *before* the fix was merged. The agent must explore thousands of files and millions of lines of code to locate the root cause.

### What Stays Hidden Until Docker Grading (Ground Truth)
3. **`patch_gold.diff`**: The reference patch authored by human maintainers that originally resolved the bug.
4. **`test_patch.diff`**: The reproduction unit tests written by maintainers.
5. **`FAIL_TO_PASS` list**: Specific test functions that failed on `base_commit` and must start passing.
6. **`PASS_TO_PASS` list**: The existing regression suite that must remain passing.

The model never sees the test patch or the test function names during reasoning. This guarantees the model is not simply writing code designed to pass an overfitted assertion string.

---

## 2. The Output Contract: Exactly One Unified Patch

The interaction contract between the AI agent and SWE-bench is strict:

```text
[issue.md] + [Repo @ base_commit]  ──▶  AI Coding Agent  ──▶  [patch.diff]
```

When the agent finishes its search, reasoning, and editing loop, its entire submission file must consist of a prediction JSON record containing three fields:

```json
{
  "instance_id": "django__django-14787",
  "model_name_or_path": "buildstation-qwen-14b-autocoderover",
  "model_patch": "diff --git a/django/db/models/sql/query.py b/django/db/models/sql/query.py\nindex ..."
}
```

- No interactive dialogue with a reviewer.
- No conversational scratchpad explanations.
- No human-in-the-loop guidance.

If git fails to apply the patch cleanly due to malformed hunk headers, syntax errors, or conflicts, the task aborts immediately with an `ERROR` status (0% score).

---

## 3. The Docker Evaluation Architecture: 3 Stacked Layers

Grading in SWE-bench is hermetic. To ensure evaluation runs identically on an NVIDIA cluster, an Apple Silicon laptop, or a consumer 16GB Linux rig, SWE-bench constructs a 3-layer Docker image stack:

<div style="margin: 2.5rem 0; text-align: center;">
  <img src="https://buildstationai.com/wp-content/uploads/2026/11/swebench_02_docker_pipeline.png" alt="SWE-bench 3-Layer Docker Execution Pipeline Diagram" style="width: 100%; border-radius: 8px; border: 1px solid var(--grid); display: block;" />
  <p style="font-family: var(--font-mono); font-size: 13px; color: var(--text-dim); margin-top: 12px;">
    Fig 2: The 3-tier Docker image hierarchy and the runtime patch-and-test execution pipeline.
  </p>
</div>

### The Docker Image Hierarchy
1. **Layer 1: SWE-bench Base Image**  
   A standardized Ubuntu/Debian foundation containing Python build tooling, git, diffutils, and evaluation harnesses.
2. **Layer 2: Environment Image**  
   Repository- and version-specific environment containing pre-compiled dependencies (e.g., Python 3.9, gcc, libffi, PostgreSQL bindings). Because each repo version has unique dependencies, storing these images requires roughly **120 GB of local disk space**.
3. **Layer 3: Instance Image**  
   A temporary container instance checked out cleanly at the task's `base_commit`.

### The 3-Step Container Execution Pipeline
When grading begins, the evaluation engine executes three consecutive commands inside the container:

```bash
# Step 1: Apply the AI model's proposed patch
git apply candidate_patch.diff

# Step 2: Inject the hidden test patch authored by repo maintainers
git apply test_patch.diff

# Step 3: Run pytest exclusively targeting the dual evaluation lists
pytest $FAIL_TO_PASS $PASS_TO_PASS --no-header -rA
```

All network access is disabled inside the evaluation container. The test execution is entirely local, deterministic, and isolated.

---

## 4. The Binary Verdict: Why 11/12 Passing Tests = 0% Credit

In traditional academic benchmarks like HumanEval or MBPP, models are graded on isolated function synthesis with unit tests (`pass@k`).

SWE-bench models software engineering as it actually happens in production CI/CD pipelines. That means **zero partial credit**.

<div style="margin: 2.5rem 0; text-align: center;">
  <img src="https://buildstationai.com/wp-content/uploads/2026/11/swebench_03_zero_credit_rule.png" alt="SWE-bench Binary Verdict & Zero Credit Rule Diagram" style="width: 100%; border-radius: 8px; border: 1px solid var(--grid); display: block;" />
  <p style="font-family: var(--font-mono); font-size: 13px; color: var(--text-dim); margin-top: 12px;">
    Fig 3: The binary scoring verdict. Passing 11 out of 12 tests yields zero credit because the single failure blocks deployment.
  </p>
</div>

### Scenario A: 11 Out of 12 Tests Pass (0.00% Score)
Suppose an AI model correctly deduces a complex bug in Django's query aggregator. It writes a 20-line patch that fixes the issue. It runs the evaluation suite:
- 1/1 `FAIL_TO_PASS` test passes (the bug is fixed).
- 10/11 `PASS_TO_PASS` regression tests pass.
- 1 regression test fails (`AssertionError: expected <200> got <500>`).

```text
================================== FAILURES ===================================
________________________ test_schema_reverse_foreign_key ______________________
    def test_schema_reverse_foreign_key():
>       assert response.status_code == 200
E       AssertionError: expected <200> got <500>

=========================== short test summary info ===========================
FAILED tests/queries/test_schema.py::test_schema_reverse_foreign_key
PASSED tests/queries/test_aggregate.py::test_q_subquery_plus
======================== 1 failed, 11 passed in 14.82s ========================

SWE-BENCH OFFICIAL STATUS: ❌ UNRESOLVED (0.00% CREDIT)
```

The model does not receive 91.6% credit. It receives **0.00%**.

Why? Because in production, a pull request that breaks an existing regression test fails continuous integration, halts deployment, and is blocked by the merge queue. A fix that breaks existing functionality is a regression, not a partial success.

### Scenario B: 12 Out of 12 Tests Pass (100.0% Score)
To earn credit for a task, the patch must achieve 100% green status across both lists:
- All `FAIL_TO_PASS` tests must pass (proving the bug was resolved).
- All `PASS_TO_PASS` tests must pass (proving no regressions were introduced).

Only then does the instance status flip to `RESOLVED`.

---

## 5. Benchmark Flavors: Full, Lite, and Verified

When reading research papers or corporate model releases, you will encounter three primary flavors of the benchmark:

| Benchmark Flavor | Task Count | Description | Primary Use Case |
|---|---|---|---|
| **SWE-bench Full** | `2,294` tasks | The original corpus across 12 Python repositories. | Comprehensive academic evaluation (~120GB storage, 40+ hours). |
| **SWE-bench Lite** | `300` tasks | A sampled cross-section of tasks designed for rapid iteration. | Fast local benchmarking and harness validation loops. |
| **SWE-bench Verified** | `500` tasks | Human-audited tasks verified as unambiguously solvable. | **The industry standard** cited by frontier labs and open-weight leaderboards. |

In the original SWE-bench dataset, researchers discovered that a subset of tasks suffered from underspecified issue descriptions, flaky unit tests, or over-constrained environments. OpenAI partnered with the SWE-bench authors to human-audit 500 tasks, creating **SWE-bench Verified**. When frontier models claim 50%+ resolve rates, they are almost universally citing Verified.

---

## 6. The Architectural Catch: Harness vs. Model

Leaderboards display model names in bold type: *"Claude 3.5 Sonnet: 49.0%"*, *"OpenAI o1: 60.7%"*, or *"Qwen 2.5 Coder: 34.0%"*.

This creates a fundamental misunderstanding: **developers assume the benchmark tests the model weights.**

It does not. **SWE-bench evaluates the model-harness tuple.**

<div style="margin: 2.5rem 0; text-align: center;">
  <img src="https://buildstationai.com/wp-content/uploads/2026/11/swebench_04_harness_vs_model.png" alt="Harness vs Model Scaffolding Delta Diagram" style="width: 100%; border-radius: 8px; border: 1px solid var(--grid); display: block;" />
  <p style="font-family: var(--font-mono); font-size: 13px; color: var(--text-dim); margin-top: 12px;">
    Fig 4: The scaffolding delta. Holding local model weights and hardware constant, the agent harness drives a 30+ percentage point difference.
  </p>
</div>

The evaluation harness only inspects the output `patch.diff`. Everything that happens between ingesting `issue.md` and writing that diff is determined by the **agent scaffold**:

1. **Repository Exploration:** Does the agent guess file names, or does it use ripgrep and Abstract Syntax Tree (AST) symbol navigation to locate relevant classes?
2. **Interactive Sandboxing:** Does the agent execute code blind in a single shot, or does it run reproduction tests inside a local terminal, read the traceback, and iterate on edits?
3. **Patch Assembly:** Does it generate full files (wasting context tokens), or does it use search-and-replace edit blocks formatted for clean `git apply` execution?

Take the exact same weights (e.g. Qwen 2.5 Coder 14B). 
- Run it through a primitive zero-shot prompt: **~8% to 12% resolve rate**.
- Run those exact same weights through an agent scaffold like AutoCodeRover, Aider, or OpenHands: **~32% to 45% resolve rate**.

---

## 7. The Buildstation Rig: Measuring Scaffolds on 16GB VRAM

Frontier model numbers rely on massive cloud API clusters with hundreds of billions of parameters and limitless token budgets.

At Buildstation, our focus is the machine you actually own:

<div class="bs-callout bs-callout-accent">
  <div class="bs-callout-title" style="color: var(--accent);">// THE BENCH RIG CONSTRAINTS</div>
  <p style="margin: 0; font-family: var(--font-mono); font-size: 14px; line-height: 1.6;">
    • <strong>VRAM:</strong> 16GB (NVIDIA GeForce RTX 4060 Ti 16GB)<br>
    • <strong>CPU:</strong> Intel Core i7-14700KF (20 cores, 28 threads)<br>
    • <strong>RAM:</strong> 64GB DDR5 @ 5600MHz<br>
    • <strong>OS:</strong> Ubuntu 24.04 LTS (Kernel 6.8)<br>
    • <strong>Local Inference:</strong> vLLM / llama.cpp (Qwen 2.5 Coder 7B/14B, DeepSeek-Coder)
  </p>
</div>

When constrained to a strict 16GB VRAM ceiling, you cannot brute-force repository context into a 128k prompt window. Every prompt token consumes valuable KV-cache allocation.

Under consumer hardware constraints, **harness engineering is king**:
- Lightweight retrieval that pinpoints exact functions saves 90% of prompt tokens.
- Structured AST extraction allows 14B models to navigate multi-million line codebases without spilling into system RAM.
- Local test execution loops let small models catch syntax errors before committing.

In our upcoming video benchmark, we test identical local open-weight models across multiple agent scaffolds on our 16GB workstation.

---

## 📺 Watch the 60-Second Video Breakdown

Watch the animated summary breaking down the Docker test matrix in 60 seconds:

<div class="bs-video-embed-wrapper">
  <iframe 
    src="https://www.youtube-nocookie.com/embed/a_X-K2qRBy8" 
    title="How SWE-bench ACTUALLY Scores AI Models 🧪" 
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
    allowfullscreen>
  </iframe>
</div>

<p style="text-align: center; font-family: var(--font-mono); font-size: 14px; color: var(--text-dim); margin-top: -1.5rem; margin-bottom: 2.5rem;">
  Watch on YouTube Shorts: <a href="https://youtube.com/shorts/a_X-K2qRBy8" target="_blank" rel="noopener" style="color: var(--accent); font-weight: 700;">@BuildstationHQ/shorts →</a>
</p>

---

## How to Run SWE-bench Locally: Reproduction Commands

If you want to run SWE-bench evaluation on your own hardware, follow these production rules:

```bash
# 1. Install SWE-bench harness inside a clean virtual environment
pip install swebench

# 2. Verify your Docker daemon and disk space (budget >= 120GB)
docker info
df -h /var/lib/docker

# 3. Always test with gold patches first to verify container reproducibility
swebench-eval \
  --dataset_name princeton-nlp/SWE-bench_Lite \
  --split test \
  --predictions_path gold \
  --run_id test-gold-run

# 4. Run your candidate model predictions
swebench-eval \
  --dataset_name princeton-nlp/SWE-bench_Lite \
  --split test \
  --predictions_path predictions_qwen14b.json \
  --max_workers 4 \
  --run_id run-qwen14b-autocoderover
```

### Key Operational Rules:
- **Use a fresh `--run_id` for every attempt**: The harness caches evaluation logs per run ID; re-using a run ID will skip evaluation.
- **Run the gold patches first**: If gold patches don't score 100% on your machine, your Docker environment or dependency networking is failing.
- **Monitor disk pruning**: Each repo environment image is 2–8GB. Prune unused instance containers with `docker container prune -f` between sweeps.

---

<div style="background: rgba(37, 99, 235, 0.05); border: 1px solid var(--grid); border-radius: 8px; padding: 28px; text-align: center; margin: 3rem 0;">
  <h3 style="margin-top: 0; margin-bottom: 12px; font-family: 'Poppins', sans-serif; font-weight: 800;">Get the benchmark numbers when runs finish</h3>
  <p style="color: var(--text-dim); font-size: 15px; margin-bottom: 20px; max-width: 520px; margin-left: auto; margin-right: auto;">
    One email per video. The command, the config, and the measured throughput on 16GB VRAM.
  </p>
  <a href="/#subscribe" class="bs-btn bs-btn-primary" style="display: inline-block; padding: 12px 28px; background: var(--accent); color: #fff; font-family: 'Roboto Mono', monospace; font-weight: 700; text-decoration: none; border-radius: 6px;">Subscribe for Benchmarks →</a>
</div>
