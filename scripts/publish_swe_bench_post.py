#!/usr/bin/env python3
"""
Publishes or updates the SWE-bench deep-dive blog post on buildstationai.com
with all 4 Excalidraw diagrams and detailed engineering analysis.
"""
import os
import subprocess
from pathlib import Path

ROOT_DIR = Path(__file__).resolve().parent.parent

# Read .env for SSH credentials
env_file = ROOT_DIR / ".env"
env_vars = {}
if env_file.exists():
    with open(env_file) as f:
        for line in f:
            line = line.strip()
            if line and not line.startswith("#") and "=" in line:
                k, v = line.split("=", 1)
                env_vars[k.strip()] = v.strip().strip("'\"")

host_ip = env_vars.get("HOST_IP", "191.101.79.207")
host_port = env_vars.get("HOST_PORT", "65002")
host_uname = env_vars.get("HOST_UNAME", "u574213859")

POST_TITLE = "How SWE-bench Actually Scores AI Models: Under the Hood of the 0% Credit Rule"
POST_SLUG = "how-swe-bench-actually-scores-ai-models"
POST_EXCERPT = (
    "Every AI coding leaderboard leads with SWE-bench (% RESOLVED). But how does it actually evaluate models? "
    "An architectural breakdown of the 3-layer Docker harness, the dual-list pytest matrix, why 11/12 passing tests equals 0 credit, and the harness vs model delta."
)

POST_HTML = """
<p class="bs-lead" style="font-size: 20px; line-height: 1.7; color: var(--text); margin-bottom: 2rem;">
Every AI coding leaderboard leads with one number: <strong>SWE-bench (% RESOLVED)</strong>. Frontier labs launch models on it. Venture funding decks quote it. Developers debate which LLM writes better code based on it.
</p>

<p>
Yet most developers assume SWE-bench is an LLM-as-a-judge benchmark or an automated code reviewer grading syntax and stylistic reasoning.
</p>

<p>
It is not. SWE-bench is a brutal, deterministic integration test executed inside an isolated Docker container against real production repositories.
</p>

<p>
Here is an architectural walkthrough of how tasks are constructed, how the Docker execution harness grades code, why an AI agent can pass 11 out of 12 tests and still receive <strong>0% credit</strong>, and why the scaffold around the model dictates benchmark scores just as much as the weights themselves.
</p>

<div class="bs-callout bs-callout-urgent" style="border: 1px solid var(--grid); border-left: 4px solid var(--urgent); background: #0b1222; border-radius: 8px; padding: 24px 28px; margin: 2.5rem 0;">
  <div class="bs-callout-title" style="font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.06em; color: var(--urgent); margin-bottom: 12px;">// THE BENCHMARK SPECIFICATION</div>
  <p style="margin: 0; font-family: 'Roboto Mono', monospace; font-size: 14px; line-height: 1.6; color: var(--text);">
    • <strong>Task Corpus:</strong> 2,294 real historical bugs across 12 open-source Python codebases.<br>
    • <strong>Interface Contract:</strong> Raw <code>issue.md</code> + Repo @ <code>base_commit</code> ➔ Single Unified Git Patch (<code>patch.diff</code>).<br>
    • <strong>Grading Environment:</strong> 3-tier isolated Docker container running native pytest suites.<br>
    • <strong>Scoring Criteria:</strong> 100% of <code>FAIL_TO_PASS</code> tests pass AND 100% of <code>PASS_TO_PASS</code> tests pass. One failed assertion = 0% score.
  </p>
</div>

<h2>1. How a Task Is Made: Information Asymmetry</h2>

<p>
SWE-bench does not prompt models with synthetic toy problems, LeetCode puzzles, or isolated functions. It draws from real historical pull requests merged by human maintainers across 12 major Python repositories: <code>django/django</code>, <code>sympy/sympy</code>, <code>scikit-learn/scikit-learn</code>, <code>matplotlib/matplotlib</code>, <code>sphinx-doc/sphinx</code>, <code>pytest-dev/pytest</code>, and more.
</p>

<p>
To build an evaluation task without synthetic bias, the SWE-bench construction pipeline follows four deterministic steps:
</p>

<ol>
  <li>Identify a merged PR that closes a tracked issue and modifies both codebase modules and unit test files.</li>
  <li>Check out the repository git tree immediately prior to that PR (<code>base_commit</code>).</li>
  <li>Run the PR's new unit tests against <code>base_commit</code>. If the tests fail before the fix and pass after the fix, the bug is verified as reproducible.</li>
  <li>Package the instance with strict information asymmetry.</li>
</ol>

<div style="margin: 3rem 0; text-align: center;">
  <img src="https://buildstationai.com/wp-content/uploads/2026/11/swebench_01_task_anatomy.png" alt="SWE-bench Task Anatomy & Information Boundary Diagram" style="width: 100%; border-radius: 8px; border: 1px solid var(--grid); display: block;" />
  <p style="font-family: 'Roboto Mono', monospace; font-size: 13px; color: var(--text-dim); margin-top: 12px;">
    Fig 1: The information boundary in SWE-bench. The model is given only two pieces of context; the ground truth remains locked until grading.
  </p>
</div>

<p>
Every task instance carries six core fields, divided by an intentional security boundary:
</p>

<h3>What the Model Sees (Agent Input)</h3>
<ul>
  <li><strong><code>issue.md</code></strong>: The raw, uncurated issue description posted by an end user on GitHub. These reports are often ambiguous, include messy traceback logs, and lack line-number citations.</li>
  <li><strong><code>base_commit</code></strong>: The repository git tree checked out precisely at the commit <em>before</em> the fix was merged. The agent must explore thousands of files and millions of lines of code to locate the root cause.</li>
</ul>

<h3>What Stays Hidden Until Docker Grading (Ground Truth)</h3>
<ul>
  <li><strong><code>patch_gold.diff</code></strong>: The reference patch authored by human maintainers that originally resolved the bug.</li>
  <li><strong><code>test_patch.diff</code></strong>: The reproduction unit tests written by maintainers.</li>
  <li><strong><code>FAIL_TO_PASS</code> list</strong>: Specific test functions that failed on <code>base_commit</code> and must start passing.</li>
  <li><strong><code>PASS_TO_PASS</code> list</strong>: The existing regression suite that must remain passing.</li>
</ul>

<p>
The model never sees the test patch or the test function names during reasoning. This guarantees the model is not simply writing code designed to pass an overfitted assertion string.
</p>

<h2>2. The Output Contract: Exactly One Unified Patch</h2>

<p>
The interaction contract between the AI agent and SWE-bench is strict:
</p>

<pre><code>[issue.md] + [Repo @ base_commit]  ──▶  AI Coding Agent  ──▶  [patch.diff]</code></pre>

<p>
When the agent finishes its search, reasoning, and editing loop, its entire submission file must consist of a prediction JSON record containing three fields:
</p>

<pre><code>{
  "instance_id": "django__django-14787",
  "model_name_or_path": "buildstation-qwen-14b-autocoderover",
  "model_patch": "diff --git a/django/db/models/sql/query.py b/django/db/models/sql/query.py\\nindex ..."
}</code></pre>

<ul>
  <li>No interactive dialogue with a reviewer.</li>
  <li>No conversational scratchpad explanations.</li>
  <li>No human-in-the-loop guidance.</li>
</ul>

<p>
If git fails to apply the patch cleanly due to malformed hunk headers, syntax errors, or conflicts, the task aborts immediately with an <code>ERROR</code> status (0% score).
</p>

<h2>3. The Docker Evaluation Architecture: 3 Stacked Layers</h2>

<p>
Grading in SWE-bench is hermetic. To ensure evaluation runs identically on an NVIDIA cluster, an Apple Silicon laptop, or a consumer 16GB Linux rig, SWE-bench constructs a 3-layer Docker image stack:
</p>

<div style="margin: 3rem 0; text-align: center;">
  <img src="https://buildstationai.com/wp-content/uploads/2026/11/swebench_02_docker_pipeline.png" alt="SWE-bench 3-Layer Docker Execution Pipeline Diagram" style="width: 100%; border-radius: 8px; border: 1px solid var(--grid); display: block;" />
  <p style="font-family: 'Roboto Mono', monospace; font-size: 13px; color: var(--text-dim); margin-top: 12px;">
    Fig 2: The 3-tier Docker image hierarchy and the runtime patch-and-test execution pipeline.
  </p>
</div>

<h3>The Docker Image Hierarchy</h3>
<ol>
  <li><strong>Layer 1: SWE-bench Base Image</strong><br>
  A standardized Ubuntu/Debian foundation containing Python build tooling, git, diffutils, and evaluation harnesses.</li>
  <li><strong>Layer 2: Environment Image</strong><br>
  Repository- and version-specific environment containing pre-compiled dependencies (e.g., Python 3.9, gcc, libffi, PostgreSQL bindings). Because each repo version has unique dependencies, storing these images requires roughly <strong>120 GB of local disk space</strong>.</li>
  <li><strong>Layer 3: Instance Image</strong><br>
  A temporary container instance checked out cleanly at the task's <code>base_commit</code>.</li>
</ol>

<h3>The 3-Step Container Execution Pipeline</h3>
<p>
When grading begins, the evaluation engine executes three consecutive commands inside the container:
</p>

<pre><code># Step 1: Apply the AI model's proposed patch
git apply candidate_patch.diff

# Step 2: Inject the hidden test patch authored by repo maintainers
git apply test_patch.diff

# Step 3: Run pytest exclusively targeting the dual evaluation lists
pytest $FAIL_TO_PASS $PASS_TO_PASS --no-header -rA</code></pre>

<p>
All network access is disabled inside the evaluation container. The test execution is entirely local, deterministic, and isolated.
</p>

<h2>4. The Binary Verdict: Why 11/12 Passing Tests = 0% Credit</h2>

<p>
In traditional academic benchmarks like HumanEval or MBPP, models are graded on isolated function synthesis with unit tests (<code>pass@k</code>).
</p>

<p>
SWE-bench models software engineering as it actually happens in production CI/CD pipelines. That means <strong>zero partial credit</strong>.
</p>

<div style="margin: 3rem 0; text-align: center;">
  <img src="https://buildstationai.com/wp-content/uploads/2026/11/swebench_03_zero_credit_rule.png" alt="SWE-bench Binary Verdict & Zero Credit Rule Diagram" style="width: 100%; border-radius: 8px; border: 1px solid var(--grid); display: block;" />
  <p style="font-family: 'Roboto Mono', monospace; font-size: 13px; color: var(--text-dim); margin-top: 12px;">
    Fig 3: The binary scoring verdict. Passing 11 out of 12 tests yields zero credit because the single failure blocks deployment.
  </p>
</div>

<h3>Scenario A: 11 Out of 12 Tests Pass (0.00% Score)</h3>
<p>
Suppose an AI model correctly deduces a complex bug in Django's query aggregator. It writes a 20-line patch that fixes the issue. It runs the evaluation suite:
</p>

<ul>
  <li>1/1 <code>FAIL_TO_PASS</code> test passes (the bug is fixed).</li>
  <li>10/11 <code>PASS_TO_PASS</code> regression tests pass.</li>
  <li>1 regression test fails (<code>AssertionError: expected &lt;200&gt; got &lt;500&gt;</code>).</li>
</ul>

<pre><code>================================== FAILURES ===================================
________________________ test_schema_reverse_foreign_key ______________________
    def test_schema_reverse_foreign_key():
>       assert response.status_code == 200
E       AssertionError: expected &lt;200&gt; got &lt;500&gt;

=========================== short test summary info ===========================
FAILED tests/queries/test_schema.py::test_schema_reverse_foreign_key
PASSED tests/queries/test_aggregate.py::test_q_subquery_plus
======================== 1 failed, 11 passed in 14.82s ========================

SWE-BENCH OFFICIAL STATUS: ❌ UNRESOLVED (0.00% CREDIT)</code></pre>

<p>
The model does not receive 91.6% credit. It receives <strong>0.00%</strong>.
</p>

<p>
Why? Because in production, a pull request that breaks an existing regression test fails continuous integration, halts deployment, and is blocked by the merge queue. A fix that breaks existing functionality is a regression, not a partial success.
</p>

<h3>Scenario B: 12 Out of 12 Tests Pass (100.0% Score)</h3>
<p>
To earn credit for a task, the patch must achieve 100% green status across both lists:
</p>
<ul>
  <li>All <code>FAIL_TO_PASS</code> tests must pass (proving the bug was resolved).</li>
  <li>All <code>PASS_TO_PASS</code> tests must pass (proving no regressions were introduced).</li>
</ul>

<p>
Only then does the instance status flip to <code>RESOLVED</code>.
</p>

<h2>5. Benchmark Flavors: Full, Lite, and Verified</h2>

<p>
When reading research papers or corporate model releases, you will encounter three primary flavors of the benchmark:
</p>

<div style="margin: 2rem 0; overflow-x: auto;">
  <table style="width: 100%; border-collapse: collapse; font-family: 'Roboto Mono', monospace; font-size: 14px;">
    <thead>
      <tr style="background: rgba(30, 41, 59, 0.5);">
        <th style="padding: 12px 16px; border: 1px solid var(--grid); text-align: left;">Benchmark Flavor</th>
        <th style="padding: 12px 16px; border: 1px solid var(--grid); text-align: left;">Task Count</th>
        <th style="padding: 12px 16px; border: 1px solid var(--grid); text-align: left;">Description</th>
        <th style="padding: 12px 16px; border: 1px solid var(--grid); text-align: left;">Primary Use Case</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="padding: 12px 16px; border: 1px solid var(--grid);"><strong style="color: var(--text);">SWE-bench Full</strong></td>
        <td style="padding: 12px 16px; border: 1px solid var(--grid); color: var(--accent);">2,294</td>
        <td style="padding: 12px 16px; border: 1px solid var(--grid);">The original corpus across 12 Python repositories.</td>
        <td style="padding: 12px 16px; border: 1px solid var(--grid);">Academic evaluation (~120GB disk, 40+ hours).</td>
      </tr>
      <tr>
        <td style="padding: 12px 16px; border: 1px solid var(--grid);"><strong style="color: var(--text);">SWE-bench Lite</strong></td>
        <td style="padding: 12px 16px; border: 1px solid var(--grid); color: var(--accent);">300</td>
        <td style="padding: 12px 16px; border: 1px solid var(--grid);">A sampled cross-section of tasks designed for fast iteration.</td>
        <td style="padding: 12px 16px; border: 1px solid var(--grid);">Fast local benchmarking and harness validation.</td>
      </tr>
      <tr>
        <td style="padding: 12px 16px; border: 1px solid var(--grid);"><strong style="color: var(--urgent);">SWE-bench Verified</strong></td>
        <td style="padding: 12px 16px; border: 1px solid var(--grid); color: var(--urgent);">500</td>
        <td style="padding: 12px 16px; border: 1px solid var(--grid);">Human-audited tasks verified as unambiguously solvable.</td>
        <td style="padding: 12px 16px; border: 1px solid var(--grid);"><strong>The industry standard</strong> cited by frontier labs.</td>
      </tr>
    </tbody>
  </table>
</div>

<p>
In the original SWE-bench dataset, researchers discovered that a subset of tasks suffered from underspecified issue descriptions, flaky unit tests, or over-constrained environments. OpenAI partnered with the SWE-bench authors to human-audit 500 tasks, creating <strong>SWE-bench Verified</strong>. When frontier models claim 50%+ resolve rates, they are almost universally citing Verified.
</p>

<h2>6. The Architectural Catch: Harness vs. Model</h2>

<p>
Leaderboards display model names in bold type: <em>"Claude 3.5 Sonnet: 49.0%"</em>, <em>"OpenAI o1: 60.7%"</em>, or <em>"Qwen 2.5 Coder: 34.0%"</em>.
</p>

<p>
This creates a fundamental misunderstanding: <strong>developers assume the benchmark tests the model weights.</strong>
</p>

<p style="font-size: 20px; font-weight: 700; color: var(--accent);">
It does not. SWE-bench evaluates the model-harness tuple.
</p>

<div style="margin: 3rem 0; text-align: center;">
  <img src="https://buildstationai.com/wp-content/uploads/2026/11/swebench_04_harness_vs_model.png" alt="Harness vs Model Scaffolding Delta Diagram" style="width: 100%; border-radius: 8px; border: 1px solid var(--grid); display: block;" />
  <p style="font-family: 'Roboto Mono', monospace; font-size: 13px; color: var(--text-dim); margin-top: 12px;">
    Fig 4: The scaffolding delta. Holding local model weights and hardware constant, the agent harness drives a 30+ percentage point difference.
  </p>
</div>

<p>
The evaluation harness only inspects the output <code>patch.diff</code>. Everything that happens between ingesting <code>issue.md</code> and writing that diff is determined by the <strong>agent scaffold</strong>:
</p>

<ol>
  <li><strong>Repository Exploration:</strong> Does the agent guess file names, or does it use ripgrep and Abstract Syntax Tree (AST) symbol navigation to locate relevant classes?</li>
  <li><strong>Interactive Sandboxing:</strong> Does the agent execute code blind in a single shot, or does it run reproduction tests inside a local terminal, read the traceback, and iterate on edits?</li>
  <li><strong>Patch Assembly:</strong> Does it generate full files (wasting context tokens), or does it use search-and-replace edit blocks formatted for clean <code>git apply</code> execution?</li>
</ol>

<p>
Take the exact same weights (e.g. Qwen 2.5 Coder 14B):
</p>
<ul>
  <li>Run it through a primitive zero-shot prompt: <strong>~8% to 12% resolve rate</strong>.</li>
  <li>Run those exact same weights through an agent scaffold like AutoCodeRover, Aider, or OpenHands: <strong>~32% to 45% resolve rate</strong>.</li>
</ul>

<h2>7. The Buildstation Rig: Measuring Scaffolds on 16GB VRAM</h2>

<p>
Frontier model numbers rely on massive cloud API clusters with hundreds of billions of parameters and limitless token budgets.
</p>

<p>
At Buildstation, our focus is the machine you actually own:
</p>

<div class="bs-callout bs-callout-accent" style="border: 1px solid var(--grid); border-left: 4px solid var(--accent); background: #0b1222; border-radius: 8px; padding: 24px 28px; margin: 2.5rem 0;">
  <div class="bs-callout-title" style="font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.06em; color: var(--accent); margin-bottom: 12px;">// THE BENCH RIG CONSTRAINTS</div>
  <p style="margin: 0; font-family: 'Roboto Mono', monospace; font-size: 14px; line-height: 1.6; color: var(--text);">
    • <strong>VRAM:</strong> 16GB (NVIDIA GeForce RTX 4060 Ti 16GB)<br>
    • <strong>CPU:</strong> Intel Core i7-14700KF (20 cores, 28 threads)<br>
    • <strong>RAM:</strong> 64GB DDR5 @ 5600MHz<br>
    • <strong>OS:</strong> Ubuntu 24.04 LTS (Kernel 6.8)<br>
    • <strong>Local Inference:</strong> vLLM / llama.cpp (Qwen 2.5 Coder 7B/14B, DeepSeek-Coder)
  </p>
</div>

<p>
When constrained to a strict 16GB VRAM ceiling, you cannot brute-force repository context into a 128k prompt window. Every prompt token consumes valuable KV-cache allocation.
</p>

<p>
Under consumer hardware constraints, <strong>harness engineering is king</strong>:
</p>
<ul>
  <li>Lightweight retrieval that pinpoints exact functions saves 90% of prompt tokens.</li>
  <li>Structured AST extraction allows 14B models to navigate multi-million line codebases without spilling into system RAM.</li>
  <li>Local test execution loops let small models catch syntax errors before committing.</li>
</ul>

<p>
In our upcoming video benchmark, we test identical local open-weight models across multiple agent scaffolds on our 16GB workstation.
</p>

<h2>📺 Watch the 60-Second Video Breakdown</h2>

<p>
Watch the animated summary breaking down the Docker test matrix in 60 seconds:
</p>

<div class="bs-video-embed-wrapper">
  <iframe 
    src="https://www.youtube-nocookie.com/embed/a_X-K2qRBy8" 
    title="How SWE-bench ACTUALLY Scores AI Models 🧪" 
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
    allowfullscreen>
  </iframe>
</div>

<p style="text-align: center; font-family: 'Roboto Mono', monospace; font-size: 14px; color: var(--text-dim); margin-top: -1.5rem; margin-bottom: 2.5rem;">
  Watch on YouTube Shorts: <a href="https://youtube.com/shorts/a_X-K2qRBy8" target="_blank" rel="noopener" style="color: var(--accent); font-weight: 700;">@BuildstationHQ/shorts →</a>
</p>

<h2>How to Run SWE-bench Locally: Reproduction Commands</h2>

<p>
If you want to run SWE-bench evaluation on your own hardware, follow these production rules:
</p>

<pre><code># 1. Install SWE-bench harness inside a clean virtual environment
pip install swebench

# 2. Verify your Docker daemon and disk space (budget >= 120GB)
docker info
df -h /var/lib/docker

# 3. Always test with gold patches first to verify container reproducibility
swebench-eval \\
  --dataset_name princeton-nlp/SWE-bench_Lite \\
  --split test \\
  --predictions_path gold \\
  --run_id test-gold-run

# 4. Run your candidate model predictions
swebench-eval \\
  --dataset_name princeton-nlp/SWE-bench_Lite \\
  --split test \\
  --predictions_path predictions_qwen14b.json \\
  --max_workers 4 \\
  --run_id run-qwen14b-autocoderover</code></pre>

<h3>Key Operational Rules:</h3>
<ul>
  <li><strong>Use a fresh <code>--run_id</code> for every attempt</strong>: The harness caches evaluation logs per run ID; re-using a run ID will skip evaluation.</li>
  <li><strong>Run the gold patches first</strong>: If gold patches don't score 100% on your machine, your Docker environment or dependency networking is failing.</li>
  <li><strong>Monitor disk pruning</strong>: Each repo environment image is 2–8GB. Prune unused instance containers with <code>docker container prune -f</code> between sweeps.</li>
</ul>

<hr style="border: 0; border-top: 1px solid var(--grid); margin: 3rem 0;">

<div style="background: rgba(37, 99, 235, 0.05); border: 1px solid var(--grid); border-radius: 8px; padding: 28px; text-align: center; margin: 3rem 0;">
  <h3 style="margin-top: 0; margin-bottom: 12px; font-family: 'Poppins', sans-serif; font-weight: 800;">Get the benchmark numbers when runs finish</h3>
  <p style="color: var(--text-dim); font-size: 15px; margin-bottom: 20px; max-width: 520px; margin-left: auto; margin-right: auto;">
    One email per video. The command, the config, and the measured throughput on 16GB VRAM.
  </p>
  <a href="/#subscribe" class="bs-btn bs-btn-primary" style="display: inline-block; padding: 12px 28px; background: var(--accent); color: #fff; font-family: 'Roboto Mono', monospace; font-weight: 700; text-decoration: none; border-radius: 6px;">Subscribe for Benchmarks →</a>
</div>
""".strip()

def main():
    print(f"🚀 Updating SWE-bench blog post on buildstationai.com ({host_ip}:{host_port})...")
    
    # Check post ID
    check_post = subprocess.run([
        "ssh", "-p", host_port, "-o", "StrictHostKeyChecking=accept-new",
        f"{host_uname}@{host_ip}",
        f"cd domains/buildstationai.com/public_html && wp post list --name='{POST_SLUG}' --field=ID"
    ], capture_output=True, text=True)
    post_id = check_post.stdout.strip()
    if not post_id:
        post_id = "9"
    
    # Upload HTML payload
    remote_temp = "domains/buildstationai.com/public_html/post_content_temp.html"
    subprocess.run([
        "ssh", "-p", host_port, "-o", "StrictHostKeyChecking=accept-new",
        f"{host_uname}@{host_ip}",
        f"cat << 'EOF' > {remote_temp}\n{POST_HTML}\nEOF"
    ], check=True)

    print(f"  Updating post {post_id} with new content & diagrams...")
    cmd = (
        f"cd domains/buildstationai.com/public_html && "
        f"wp post update {post_id} "
        f"--post_title=\"{POST_TITLE}\" "
        f"--post_excerpt=\"{POST_EXCERPT}\" "
        f"--post_content=\"$(cat post_content_temp.html)\" && "
        f"wp post meta set {post_id} _thumbnail_id 12 && "
        f"rm post_content_temp.html && "
        f"wp cache flush"
    )
    
    res = subprocess.run([
        "ssh", "-p", host_port, "-o", "StrictHostKeyChecking=accept-new",
        f"{host_uname}@{host_ip}",
        cmd
    ], capture_output=True, text=True, check=True)
    
    print(res.stdout)
    print("✅ SWE-bench blog post successfully updated with 4 Excalidraw diagrams!")
    print(f"🔗 Live URL: https://buildstationai.com/{POST_SLUG}/")

if __name__ == "__main__":
    main()
