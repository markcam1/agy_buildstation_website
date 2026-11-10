#!/usr/bin/env python3
"""
Generate 4 Excalidraw diagrams for the SWE-bench deep-dive blog post on buildstationai.com.
Follows strict Buildstation design tokens:
  BG: #0f172a
  ACCENT: #2563eb
  TEXT: #e2e8f0
  URGENT: #00ff41 (exactly one per frame)
  TEXT_DIM: #94a3b8
  GRID: #1e293b
  DANGER: #ef4444
"""

import json
import random
from pathlib import Path

OUT_DIR = Path(__file__).resolve().parent.parent / "diagrams"
OUT_DIR.mkdir(parents=True, exist_ok=True)


def make_rect(
    id_,
    x,
    y,
    w,
    h,
    stroke="#2563eb",
    bg="#1e293b",
    stroke_width=2,
    stroke_style="solid",
    roughness=1,
    fill_style="solid",
):
    return {
        "id": id_,
        "type": "rectangle",
        "x": x,
        "y": y,
        "width": w,
        "height": h,
        "angle": 0,
        "strokeColor": stroke,
        "backgroundColor": bg,
        "fillStyle": fill_style,
        "strokeWidth": stroke_width,
        "strokeStyle": stroke_style,
        "roughness": roughness,
        "opacity": 100,
        "groupIds": [],
        "frameId": None,
        "roundness": {"type": 3},
        "seed": random.randint(1000, 99999),
        "version": 1,
        "versionNonce": random.randint(1000, 99999),
        "isDeleted": False,
        "boundElements": None,
        "updated": 1,
        "link": None,
        "locked": False,
    }


def make_text(
    id_,
    x,
    y,
    text,
    font_size=16,
    font_family=3,
    color="#e2e8f0",
    align="left",
    w=None,
    h=None,
):
    lines = text.split("\n")
    line_count = len(lines)
    max_len = max(len(l) for l in lines)
    calc_w = w if w is not None else int(max_len * font_size * 0.6) + 14
    calc_h = h if h is not None else int(line_count * font_size * 1.35)
    return {
        "id": id_,
        "type": "text",
        "x": x,
        "y": y,
        "width": calc_w,
        "height": calc_h,
        "angle": 0,
        "strokeColor": color,
        "backgroundColor": "transparent",
        "fillStyle": "solid",
        "strokeWidth": 1,
        "strokeStyle": "solid",
        "roughness": 0,
        "opacity": 100,
        "groupIds": [],
        "frameId": None,
        "roundness": None,
        "seed": random.randint(1000, 99999),
        "version": 1,
        "versionNonce": random.randint(1000, 99999),
        "isDeleted": False,
        "boundElements": None,
        "updated": 1,
        "link": None,
        "locked": False,
        "text": text,
        "fontSize": font_size,
        "fontFamily": font_family,
        "textAlign": align,
        "verticalAlign": "top",
        "baseline": int(font_size * 0.9),
        "lineHeight": 1.3,
    }


def make_arrow(
    id_,
    x,
    y,
    points,
    stroke="#2563eb",
    stroke_width=2,
    stroke_style="solid",
    roughness=1,
):
    return {
        "id": id_,
        "type": "arrow",
        "x": x,
        "y": y,
        "width": max(p[0] for p in points) - min(p[0] for p in points),
        "height": max(p[1] for p in points) - min(p[1] for p in points),
        "angle": 0,
        "strokeColor": stroke,
        "backgroundColor": "transparent",
        "fillStyle": "solid",
        "strokeWidth": stroke_width,
        "strokeStyle": stroke_style,
        "roughness": roughness,
        "opacity": 100,
        "groupIds": [],
        "frameId": None,
        "roundness": {"type": 2},
        "seed": random.randint(1000, 99999),
        "version": 1,
        "versionNonce": random.randint(1000, 99999),
        "isDeleted": False,
        "boundElements": None,
        "updated": 1,
        "link": None,
        "locked": False,
        "points": points,
        "startBinding": None,
        "endBinding": None,
        "startArrowhead": None,
        "endArrowhead": "arrow",
    }


def make_file(name, elements):
    data = {
        "type": "excalidraw",
        "version": 2,
        "source": "https://buildstationai.com",
        "elements": elements,
        "appState": {
            "viewBackgroundColor": "#0f172a",
            "gridSize": 20,
            "exportWithDarkMode": True,
        },
        "files": {},
    }
    p = OUT_DIR / name
    with open(p, "w", encoding="utf-8") as f:
        json.dump(data, f, indent=2)
    print(f"  ✓ Created {p.name}")
    return p


# ==============================================================================
# Diagram 1: Task Anatomy & Information Asymmetry
# ==============================================================================
def build_diag_1():
    els = []
    # Title
    els.append(make_text("t0", 60, 40, "SWE-bench Task Anatomy & Information Boundary", 28, 1, "#e2e8f0"))
    els.append(make_text("t0_sub", 60, 80, "// 6 Core Fields: 2 Exposed to Agent · 4 Hidden Until Grading", 14, 3, "#94a3b8"))

    # Left Container: What the Model Sees (Green border: Urgent / Active)
    els.append(make_rect("box_left", 60, 130, 680, 560, stroke="#00ff41", bg="#131e33", stroke_width=2))
    els.append(make_text("hdr_left", 84, 150, "1. WHAT THE MODEL SEES (AGENT INPUT)", 18, 3, "#00ff41"))
    els.append(make_text("desc_left", 84, 180, "Exposed via prompt & read-only repository context:", 14, 1, "#94a3b8"))

    # Artifact 1: issue.md
    els.append(make_rect("card_issue", 84, 215, 632, 210, stroke="#1e293b", bg="#090e1a", stroke_width=1))
    els.append(make_text("lbl_issue", 104, 230, "📄 issue.md (RAW GITHUB ISSUE TEXT)", 15, 3, "#e2e8f0"))
    issue_sample = (
        "### Bug Description:\n"
        "QuerySet.aggregate() fails with TypeError on custom expressions\n"
        "when combining Q() filters with OuterRef subqueries.\n"
        "Traceback (most recent call last):\n"
        "  File \"django/db/models/sql/query.py\", line 1420, in resolve\n"
        "TypeError: unsupported operand type(s) for +: 'NoneType' and 'int'"
    )
    els.append(make_text("code_issue", 104, 265, issue_sample, 13, 3, "#94a3b8"))

    # Artifact 2: base_commit
    els.append(make_rect("card_base", 84, 445, 632, 215, stroke="#1e293b", bg="#090e1a", stroke_width=1))
    els.append(make_text("lbl_base", 104, 460, "📦 base_commit (PRE-FIX GIT TREE)", 15, 3, "#e2e8f0"))
    base_sample = (
        "Repository: django/django\n"
        "Commit:     e89ab32f641c88d891 (Before human maintainer fix)\n"
        "Files:      4,820 Python modules (~1.2M lines of code)\n"
        "\n"
        "-> Model must locate, understand, and patch the root cause\n"
        "   without any human direction or line-number hints."
    )
    els.append(make_text("code_base", 104, 495, base_sample, 13, 3, "#94a3b8"))

    # Right Container: Hidden until Grading (Blue border)
    els.append(make_rect("box_right", 780, 130, 680, 560, stroke="#2563eb", bg="#131e33", stroke_width=2))
    els.append(make_text("hdr_right", 804, 150, "2. HIDDEN UNTIL DOCKER GRADING (THE GROUND TRUTH)", 18, 3, "#2563eb"))
    els.append(make_text("desc_right", 804, 180, "Strictly kept out of prompt context to prevent data leakage:", 14, 1, "#94a3b8"))

    # Artifact 3: patch_gold.diff
    els.append(make_rect("card_gold", 804, 215, 632, 110, stroke="#1e293b", bg="#090e1a", stroke_width=1))
    els.append(make_text("lbl_gold", 824, 230, "🔒 patch_gold.diff (HUMAN REFERENCE FIX)", 14, 3, "#e2e8f0"))
    els.append(make_text("code_gold", 824, 260, "The real PR patch created by maintainers to fix the issue.\nKept hidden to test generalization, not memorization.", 13, 1, "#94a3b8"))

    # Artifact 4: test_patch.diff
    els.append(make_rect("card_test", 804, 340, 632, 110, stroke="#1e293b", bg="#090e1a", stroke_width=1))
    els.append(make_text("lbl_test", 824, 355, "🔒 test_patch.diff (REPRODUCTION UNIT TESTS)", 14, 3, "#e2e8f0"))
    els.append(make_text("code_test", 824, 385, "New unit tests written specifically to trigger the bug.\nApplied to container ONLY during grading.", 13, 1, "#94a3b8"))

    # Artifact 5 & 6: Test lists
    els.append(make_rect("card_lists", 804, 465, 632, 195, stroke="#1e293b", bg="#090e1a", stroke_width=1))
    els.append(make_text("lbl_lists", 824, 480, "🔒 TEST EVALUATION MATRICES (pytest selectors)", 14, 3, "#e2e8f0"))
    lists_sample = (
        "FAIL_TO_PASS List: [tests that failed on base_commit]\n"
        "  • tests/queries/test_aggregate.py::test_q_subquery_plus\n"
        "\n"
        "PASS_TO_PASS List: [regression suite that must stay green]\n"
        "  • tests/queries/test_basic.py::test_filter_join\n"
        "  • tests/queries/test_models.py::test_foreign_key"
    )
    els.append(make_text("code_lists", 824, 510, lists_sample, 13, 3, "#94a3b8"))

    # Bottom summary pill
    els.append(make_rect("bot_pill", 60, 720, 1400, 60, stroke="#1e293b", bg="#090e1a"))
    els.append(make_text("bot_txt", 80, 738, "THE SINGLE CONTRACT: Agent outputs exactly ONE file: patch.diff. No conversational reasoning is evaluated.", 15, 3, "#e2e8f0"))

    make_file("swebench_01_task_anatomy.excalidraw", els)


# ==============================================================================
# Diagram 2: Docker Grading Pipeline Architecture
# ==============================================================================
def build_diag_2():
    els = []
    els.append(make_text("t0", 60, 40, "SWE-bench 3-Layer Docker Execution Pipeline", 28, 1, "#e2e8f0"))
    els.append(make_text("t0_sub", 60, 80, "// Hermetic Containerization: Guaranteed Reproducibility on Local Machine", 14, 3, "#94a3b8"))

    # Left: Layer Stack
    els.append(make_rect("box_layers", 60, 130, 520, 560, stroke="#2563eb", bg="#131e33"))
    els.append(make_text("hdr_layers", 84, 150, "DOCKER IMAGE LAYER STACK", 18, 3, "#2563eb"))
    els.append(make_text("sub_layers", 84, 180, "Pre-built and cached locally (~120GB storage):", 14, 1, "#94a3b8"))

    # Layer 3 (Instance)
    els.append(make_rect("lyr3", 84, 220, 472, 115, stroke="#2563eb", bg="#090e1a"))
    els.append(make_text("lyr3_t", 104, 235, "LAYER 3: INSTANCE IMAGE", 15, 3, "#e2e8f0"))
    els.append(make_text("lyr3_d", 104, 265, "Git checkout pinned to task base_commit.\nIsolated sandbox where patches are applied.", 13, 1, "#94a3b8"))

    # Layer 2 (Environment)
    els.append(make_rect("lyr2", 84, 355, 472, 135, stroke="#1e293b", bg="#090e1a"))
    els.append(make_text("lyr2_t", 104, 370, "LAYER 2: REPO ENVIRONMENT IMAGE", 15, 3, "#e2e8f0"))
    els.append(make_text("lyr2_d", 104, 400, "Pinned Python runtime (e.g. 3.9, 3.10)\nAll C-extensions, gcc, libffi, dependencies.\nOne environment image per repository version.", 13, 1, "#94a3b8"))

    # Layer 1 (Base)
    els.append(make_rect("lyr1", 84, 510, 472, 115, stroke="#1e293b", bg="#090e1a"))
    els.append(make_text("lyr1_t", 104, 525, "LAYER 1: SWE-BENCH BASE IMAGE", 15, 3, "#e2e8f0"))
    els.append(make_text("lyr1_d", 104, 555, "Debian/Ubuntu baseline container.\nIncludes pytest, git, diffutils, evaluation harnesses.", 13, 1, "#94a3b8"))

    # Connecting Arrow
    els.append(make_arrow("arr_stack_run", 580, 410, [[0, 0], [60, 0]], stroke="#2563eb", stroke_width=3))

    # Right: Grading Sequence
    els.append(make_rect("box_seq", 660, 130, 800, 560, stroke="#1e293b", bg="#131e33"))
    els.append(make_text("hdr_seq", 684, 150, "DOCKER RUNTIME GRADING SEQUENCE", 18, 3, "#e2e8f0"))

    # Step 1: Model patch
    els.append(make_rect("s1", 684, 200, 752, 95, stroke="#1e293b", bg="#090e1a"))
    els.append(make_text("s1_n", 704, 215, "STEP 01: APPLY AGENT'S PATCH", 14, 3, "#2563eb"))
    els.append(make_text("s1_c", 704, 245, "$ git apply candidate_patch.diff   # Aborts immediately if rejected", 13, 3, "#94a3b8"))

    # Step 2: Hidden test patch
    els.append(make_rect("s2", 684, 315, 752, 95, stroke="#1e293b", bg="#090e1a"))
    els.append(make_text("s2_n", 704, 330, "STEP 02: INJECT HIDDEN EVALUATION TESTS", 14, 3, "#2563eb"))
    els.append(make_text("s2_c", 704, 360, "$ git apply test_patch.diff        # Adds reproduction assertions", 13, 3, "#94a3b8"))

    # Step 3: Pytest Execution (Neon Green highlight)
    els.append(make_rect("s3", 684, 430, 752, 175, stroke="#00ff41", bg="#090e1a", stroke_width=2))
    els.append(make_text("s3_n", 704, 450, "STEP 03: EXECUTE PYTEST ACROSS DUAL-LIST MATRIX", 15, 3, "#00ff41"))
    els.append(make_text("s3_c", 704, 480, "$ pytest $FAIL_TO_PASS $PASS_TO_PASS --no-header", 13, 3, "#e2e8f0"))
    els.append(make_text("s3_out", 704, 515, "================ 12 passed in 14.82s ================", 14, 3, "#00ff41"))
    els.append(make_text("s3_note", 704, 545, "Execution runs strictly within container — zero network egress.", 13, 1, "#94a3b8"))

    # Bottom summary pill
    els.append(make_rect("bot_pill2", 60, 720, 1400, 60, stroke="#1e293b", bg="#090e1a"))
    els.append(make_text("bot_txt2", 80, 738, "HERMETIC TESTING: Every evaluation uses identical isolated images so scores remain 100% reproducible.", 15, 3, "#e2e8f0"))

    make_file("swebench_02_docker_pipeline.excalidraw", els)


# ==============================================================================
# Diagram 3: Binary Verdict & Zero Credit Rule
# ==============================================================================
def build_diag_3():
    els = []
    els.append(make_text("t0", 60, 40, "The Binary Verdict: Why 11/12 Passing Tests = 0% Credit", 28, 1, "#e2e8f0"))
    els.append(make_text("t0_sub", 60, 80, "// In Production CI/CD, A Single Broken Regression Blocks The Release", 14, 3, "#94a3b8"))

    # Run A: 11/12 Tests (Failure / Red)
    els.append(make_rect("box_fail", 60, 130, 680, 560, stroke="#ef4444", bg="#131e33", stroke_width=2))
    els.append(make_text("hdr_fail", 84, 150, "SCENARIO A: 11 / 12 TESTS PASS (PARTIAL FIX)", 18, 3, "#ef4444"))
    els.append(make_text("sub_fail", 84, 180, "Model fixed the primary bug, but broke an existing edge case:", 14, 1, "#94a3b8"))

    # Grid of pills: 11 Green, 1 Red
    test_grid_a = [
        ("test_join_01", "#00ff41"), ("test_join_02", "#00ff41"), ("test_filter", "#00ff41"),
        ("test_q_object", "#00ff41"), ("test_subquery", "#00ff41"), ("test_models", "#00ff41"),
        ("test_alias", "#00ff41"), ("test_ordering", "#00ff41"), ("test_limit", "#00ff41"),
        ("test_distinct", "#00ff41"), ("test_lookup", "#00ff41"), ("test_schema", "#ef4444"),
    ]
    for idx, (tname, col) in enumerate(test_grid_a):
        gx = 84 + (idx % 3) * 208
        gy = 215 + (idx // 3) * 58
        els.append(make_rect(f"pill_a_{idx}", gx, gy, 196, 46, stroke=col, bg="#090e1a", stroke_width=1))
        status_txt = "PASS" if col == "#00ff41" else "FAIL"
        els.append(make_text(f"txt_a_{idx}", gx + 12, gy + 14, f"{tname} [{status_txt}]", 12, 3, col))

    # Verdict Card A
    els.append(make_rect("verdict_a", 84, 480, 632, 180, stroke="#ef4444", bg="#090e1a", stroke_width=2))
    els.append(make_text("va_title", 104, 500, "SWE-BENCH OFFICIAL VERDICT:", 14, 3, "#94a3b8"))
    els.append(make_text("va_stat", 104, 530, "❌ UNRESOLVED  (SCORE: 0.00%)", 24, 3, "#ef4444"))
    els.append(make_text("va_expl", 104, 580, "No partial credit. 11/12 passing does not earn 91.6%.\nIn production, regression in test_schema blocks the release.", 14, 1, "#e2e8f0"))

    # Run B: 12/12 Tests (Success / Neon Green)
    els.append(make_rect("box_pass", 780, 130, 680, 560, stroke="#00ff41", bg="#131e33", stroke_width=2))
    els.append(make_text("hdr_pass", 804, 150, "SCENARIO B: 12 / 12 TESTS PASS (HERMETIC RESOLUTION)", 18, 3, "#00ff41"))
    els.append(make_text("sub_pass", 804, 180, "Bug fixed cleanly with 100% regression compatibility:", 14, 1, "#94a3b8"))

    # Grid of pills: 12 Green
    for idx in range(12):
        gx = 804 + (idx % 3) * 208
        gy = 215 + (idx // 3) * 58
        els.append(make_rect(f"pill_b_{idx}", gx, gy, 196, 46, stroke="#00ff41", bg="#090e1a", stroke_width=1))
        els.append(make_text(f"txt_b_{idx}", gx + 12, gy + 14, f"test_case_{idx+1:02d} [PASS]", 12, 3, "#00ff41"))

    # Verdict Card B
    els.append(make_rect("verdict_b", 804, 480, 632, 180, stroke="#00ff41", bg="#090e1a", stroke_width=2))
    els.append(make_text("vb_title", 824, 500, "SWE-BENCH OFFICIAL VERDICT:", 14, 3, "#94a3b8"))
    els.append(make_text("vb_stat", 824, 530, "✓ RESOLVED  (SCORE: 100.0%)", 24, 3, "#00ff41"))
    els.append(make_text("vb_expl", 824, 580, "Full credit granted. Patch cleanly passed all FAIL_TO_PASS tests\nwithout causing regressions in any PASS_TO_PASS suite.", 14, 1, "#e2e8f0"))

    # Bottom summary pill
    els.append(make_rect("bot_pill3", 60, 720, 1400, 60, stroke="#1e293b", bg="#090e1a"))
    els.append(make_text("bot_txt3", 80, 738, "PRODUCTION PRINCIPLE: Partial solutions that break existing tests are regressions, not partial successes.", 15, 3, "#e2e8f0"))

    make_file("swebench_03_zero_credit_rule.excalidraw", els)


# ==============================================================================
# Diagram 4: Harness vs Model Architecture
# ==============================================================================
def build_diag_4():
    els = []
    els.append(make_text("t0", 60, 40, "Harness vs. Model: The Scaffolding Delta on 16GB VRAM", 28, 1, "#e2e8f0"))
    els.append(make_text("t0_sub", 60, 80, "// Identical Model Weights Yield Radically Different Benchmark Scores", 14, 3, "#94a3b8"))

    # Center-Left: The Local Model Engine
    els.append(make_rect("box_model", 60, 240, 360, 340, stroke="#2563eb", bg="#131e33", stroke_width=2))
    els.append(make_text("bm_t", 84, 265, "LOCAL MODEL WEIGHTS", 18, 3, "#2563eb"))
    els.append(make_text("bm_sub", 84, 295, "(Fixed Core Constraint: 16GB VRAM)", 14, 1, "#94a3b8"))

    model_specs = (
        "• Model: Qwen 2.5 Coder 14B\n"
        "• Rig:   RTX 4060 Ti 16GB\n"
        "• RAM:   64GB DDR5\n"
        "• Engine: vLLM (Local API)\n"
        "\n"
        "The model weights and\n"
        "inference hardware remain\n"
        "100% IDENTICAL in both tests."
    )
    els.append(make_rect("bm_card", 84, 335, 312, 220, stroke="#1e293b", bg="#090e1a"))
    els.append(make_text("bm_desc", 100, 350, model_specs, 13, 3, "#e2e8f0"))

    # Arrow to Branch 1
    els.append(make_arrow("arr_b1", 420, 320, [[0, 0], [80, -90]], stroke="#1e293b", stroke_width=2))
    # Arrow to Branch 2
    els.append(make_arrow("arr_b2", 420, 460, [[0, 0], [80, 70]], stroke="#00ff41", stroke_width=3))

    # Branch 1 (Top): Primitive Scaffolding
    els.append(make_rect("box_b1", 520, 130, 940, 230, stroke="#1e293b", bg="#131e33"))
    els.append(make_text("b1_t", 544, 150, "SCAFFOLD A: PRIMITIVE ZERO-SHOT / SINGLE-TURN PROMPT", 16, 3, "#94a3b8"))
    b1_info = (
        "Pipeline: Prompt -> LLM generates diff -> Write to file.\n"
        "• No tool use or directory exploration.\n"
        "• Blind guessing on file locations.\n"
        "• No syntax check or unit test verification."
    )
    els.append(make_text("b1_desc", 544, 185, b1_info, 13, 1, "#94a3b8"))
    els.append(make_rect("b1_score_box", 1160, 160, 270, 120, stroke="#ef4444", bg="#090e1a"))
    els.append(make_text("b1_lbl", 1180, 175, "SWE-BENCH SCORE:", 13, 3, "#94a3b8"))
    els.append(make_text("b1_val", 1180, 205, "~8% - 12%", 28, 3, "#ef4444"))

    # Branch 2 (Bottom): Advanced Agent Scaffold (Neon Green)
    els.append(make_rect("box_b2", 520, 390, 940, 300, stroke="#00ff41", bg="#131e33", stroke_width=2))
    els.append(make_text("b2_t", 544, 410, "SCAFFOLD B: AGENTIC HARNESS (AutoCodeRover / Aider / OpenHands)", 16, 3, "#00ff41"))

    # 3 Sub-capabilities
    els.append(make_rect("cap1", 544, 450, 190, 140, stroke="#1e293b", bg="#090e1a"))
    els.append(make_text("c1_t", 558, 465, "1. SEARCH", 13, 3, "#2563eb"))
    els.append(make_text("c1_d", 558, 495, "AST syntax tree\n& ripgrep symbols.\nPinpoints exact files.", 12, 1, "#94a3b8"))

    els.append(make_rect("cap2", 748, 450, 190, 140, stroke="#1e293b", bg="#090e1a"))
    els.append(make_text("c2_t", 762, 465, "2. TEST LOOP", 13, 3, "#2563eb"))
    els.append(make_text("c2_d", 762, 495, "Runs tests in Docker.\nReads stack traces\n& self-corrects.", 12, 1, "#94a3b8"))

    els.append(make_rect("cap3", 952, 450, 190, 140, stroke="#1e293b", bg="#090e1a"))
    els.append(make_text("c3_t", 966, 465, "3. DIFF MERGE", 13, 3, "#2563eb"))
    els.append(make_text("c3_d", 966, 495, "Search-and-replace\nblocks formatted for\ngit apply clean exit.", 12, 1, "#94a3b8"))

    els.append(make_rect("b2_score_box", 1160, 460, 270, 120, stroke="#00ff41", bg="#090e1a", stroke_width=2))
    els.append(make_text("b2_lbl", 1180, 475, "SWE-BENCH SCORE:", 13, 3, "#94a3b8"))
    els.append(make_text("b2_val", 1180, 505, "~32% - 45%", 28, 3, "#00ff41"))

    # Bottom summary pill
    els.append(make_rect("bot_pill4", 60, 720, 1400, 60, stroke="#1e293b", bg="#090e1a"))
    els.append(make_text("bot_txt4", 80, 738, "CRITICAL LESSON: Leaderboards test the (Model + Harness) tuple. On 16GB VRAM, harness engineering is king.", 15, 3, "#e2e8f0"))

    make_file("swebench_04_harness_vs_model.excalidraw", els)


def main():
    print("🎨 Generating Excalidraw diagrams for SWE-bench...")
    build_diag_1()
    build_diag_2()
    build_diag_3()
    build_diag_4()
    print("✨ All diagrams generated!")


if __name__ == "__main__":
    main()
