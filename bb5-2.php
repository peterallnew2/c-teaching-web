<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C 語言 第五章 Part 2: 陣列與指標</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>

    <script>
    MathJax = {
      tex: {
        inlineMath: [['$', '$'], ['\\(', '\\)']],
        displayMath: [['$$', '$$'], ['\\[', '\\]']]
      }
    };
    </script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&family=Source+Code+Pro:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4a90e2;
            --background-color: #1e1e1e;
            --text-color: #dcdcdc;
            --header-color: #ffffff;
            --card-bg: #2d2d2d;
            --border-color: #444;
            --code-bg: #282c34;
            --success-color: #73c990;
            --error-color: #f47174;
            --font-body: 'Noto Sans TC', sans-serif;
            --font-code: 'Source Code Pro', monospace;
        }
        body {
            font-family: var(--font-body);
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.2;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .container {
            display: flex;
            max-width: 100%;
            height: 100vh;
            margin: 0 auto;
            padding: 0;
        }
        .tutorial-content {
            width: 70%;
            min-width: 350px;
            padding: 20px 40px;
            box-sizing: border-box;
            overflow-y: auto;
            height: 100vh;
        }
        .resizer {
            width: 8px;
            cursor: col-resize;
            background-color: var(--border-color);
            flex-shrink: 0;
            transition: background-color 0.2s;
        }
        .resizer:hover, .resizer.is-dragging {
            background-color: var(--primary-color);
        }
        .interactive-panel {
            width: 30%;
            min-width: 420px;
            flex-grow: 1;
            position: relative;
            height: 100vh;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
        }
        h1, h2 {
            color: var(--header-color);
            font-weight: 700;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
        }
        h1 { font-size: 2.0em; margin-bottom:15px;}
        h2 { font-size: 1.6em; margin-top: 25px; }

        p, ul, ol {
            font-size: 0.95em;
            line-height: 1.6;
            margin-bottom: 0.7em;
        }
        ul, ol {
            padding-left: 20px;
        }
        li {
            margin-bottom: 6px;
        }
        code:not(pre > code) {
            background-color: var(--card-bg);
            color: var(--primary-color);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: var(--font-code);
        }
        pre {
            margin: 0.8em 0;
            padding: 10px;
            background-color: var(--code-bg);
            border-radius: 4px;
            overflow-x: auto;
            font-size: 0.85em;
        }
        .explanation table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            margin-bottom: 12px;
            font-size: 0.85em;
            background-color: var(--code-bg);
        }
        .explanation th, .explanation td {
            border: 1px solid var(--border-color);
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }
        .explanation th {
            background-color: var(--primary-color);
            color: white;
            font-weight: bold;
        }
        .explanation td code {
             background-color: rgba(255,255,255,0.1);
             padding: 1px 4px;
             border-radius: 3px;
        }
        .explanation pre {
            margin: 0.5em 0;
            padding: 8px;
            background-color: rgba(0,0,0,0.2);
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .explanation .code-block-within-explanation pre {
             background-color: var(--code-bg);
        }

        .run-example-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 7px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-family: var(--font-body);
            font-weight: 500;
            transition: background-color 0.3s;
            margin-top: 5px;
            margin-bottom: 10px;
            font-size: 0.85em;
        }
        .run-example-btn:hover {
            background-color: #357ABD;
        }
        .interactive-panel-inner {
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%;
            gap: 15px;
        }
        .sandbox-container {
            background-color: var(--card-bg);
            border-radius: 8px;
            padding: 15px;
            border: 1px solid var(--border-color);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .sandbox-container h3 {
            margin-top: 0;
            color: var(--primary-color);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 8px;
            font-size: 1.2em;
            flex-shrink: 0;
        }
        #code-editor {
            width: 100%;
            flex-grow: 1;
            background-color: var(--code-bg);
            color: var(--text-color);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-family: var(--font-code);
            font-size: 0.9em;
            padding: 10px;
            box-sizing: border-box;
            resize: vertical;
            min-height: 150px;
        }
        .sandbox-controls {
            display: flex;
            justify-content: flex-end;
            padding: 8px 0;
            flex-shrink: 0;
        }
        #run-code-btn {
            background-color: var(--success-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        #run-code-btn:hover {
            background-color: #5aa777;
        }
        #run-code-btn:disabled {
            background-color: #555;
            cursor: not-allowed;
        }
        #output-area {
            background-color: #000;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            font-family: var(--font-code);
            white-space: pre-wrap;
            word-wrap: break-word;
            min-height: 80px;
            margin-top: 8px;
            flex-shrink: 0;
            font-size: 0.85em;
            overflow-y: auto;
            max-height: 250px;
        }
        .quiz-section {
            margin-top: 20px;
            background-color: transparent;
            border: none;
            padding: 0;
        }
        .quiz-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            scroll-margin-top: 20px;
        }
        .quiz-card h3 {
            margin-top: 0;
            color: var(--header-color);
            font-size: 1.1em;
            border-bottom: 1px dashed var(--border-color);
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .quiz-options .option {
            display: block;
            background-color: #3c3c3c;
            margin: 8px 0;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.3s, background-color 0.3s;
            position: relative;
            font-size: 0.9em;
        }
        .quiz-options .option:hover {
            border-color: var(--primary-color);
        }
        .quiz-options .option.correct {
            border-color: var(--success-color);
            background-color: rgba(115, 201, 144, 0.15);
        }
        .quiz-options .option.incorrect {
            border-color: var(--error-color);
            background-color: rgba(244, 113, 116, 0.15);
        }
        .quiz-options .option.answered {
            cursor: default;
        }
        .quiz-options .option.answered:hover {
            border-color: currentColor;
        }
        .quiz-options .option.correct.answered:hover {
             border-color: var(--success-color);
        }
         .quiz-options .option.incorrect.answered:hover {
             border-color: var(--error-color);
        }
        .feedback-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.1em;
        }

        .explanation {
            display: none;
            margin-top: 15px;
            padding: 15px;
            background-color: rgba(0,0,0,0.1);
            border-radius: 5px;
            border: 1px solid var(--border-color);
            line-height: 1.6;
        }
        .explanation h4 {
            margin-top: 0;
            margin-bottom: 10px;
            color: var(--primary-color);
            font-size: 1.05em;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 5px;
        }
        .explanation ul, .explanation ol {
            padding-left: 20px;
            margin-bottom: 10px;
        }
        .explanation ul li::marker {
            color: var(--primary-color);
        }
        .next-btn-container {
            text-align: right;
            margin-top: 15px;
        }
        .next-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 0.9em;
        }
        .next-btn:hover {
            background-color: #357ABD;
        }
        .preamble-code {
            background-color: var(--code-bg);
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid var(--border-color);
        }
        .preamble-text p {
            font-style: italic;
            color: #aaa;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <main class="tutorial-content">
            <h1>C 語言練習：第五章 Part 2 - 指標運算與陣列應用</h1>
            <p>本頁面為 C/C++ 語言第五章練習題的第二部分 (第 27-52 題)，繼續探討陣列、指標、記憶體管理及相關應用。請仔細分析題目，並選擇最合適的答案。部分題目附有程式碼片段，您可以點擊「運行示例」按鈕，將程式碼載入到右側的沙箱中實際執行和測試。每個問題的詳解中將提供詳細的步驟分析，包括變數追蹤表或指標/位址的詳細解說。</p>

            <div class="quiz-section">
                <h2>第五章 互動練習題組 (2/3)</h2>
                <p>請挑戰下面的題目，檢驗您的學習成果！</p>
                <!-- QUIZ CARDS START -->
                <div id="q27" class="quiz-card">
                    <h3>27. 在 C 語言中，整數陣列的第 1 個元素位址為 0x5678，則第 4 個元素位址為何？</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 0x567A</div>
                        <div class="option" data-option="B">(B) 0x5684</div>
                        <div class="option" data-option="C">(C) 0x567F</div>
                        <div class="option" data-option="D">(D) 0x5680</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：陣列元素位址計算</h4>
                        <p><b>1. 陣列元素與索引：</b></p>
                        <p>在 C 語言中，陣列索引從 0 開始。因此，「第 1 個元素」是索引為 0 的元素 (<code>arr[0]</code>)，「第 4 個元素」是索引為 3 的元素 (<code>arr[3]</code>)。</p>
                        <p><b>2. 指標算術：</b></p>
                        <p>如果一個陣列 <code>arr</code> 的首元素位址 (<code>&arr[0]</code>) 是 <code>base_address</code>，那麼第 <code>i</code> 個元素 (<code>arr[i]</code>) 的位址是：</p>
                        <p><code>&arr[i] = base_address + i * sizeof(element_type)</code></p>
                        <p>題目給定：</p>
                        <ul>
                            <li>陣列是「整數陣列」。我們假設 <code>sizeof(int) = 4</code> bytes (這是一個常見的設定)。</li>
                            <li>第 1 個元素 (<code>arr[0]</code>) 的位址是 <code>0x5678</code>。</li>
                        </ul>
                        <p>我們要找的是第 4 個元素 (即 <code>arr[3]</code>) 的位址。</p>
                        <p>使用公式，<code>i = 3</code>：</p>
                        <p>位址 of <code>arr[3]</code> = <code>0x5678 + 3 * sizeof(int)</code></p>
                        <p>位址 of <code>arr[3]</code> = <code>0x5678 + 3 * 4</code> bytes</p>
                        <p>位址 of <code>arr[3]</code> = <code>0x5678 + 12</code> bytes</p>
                        <p>現在進行十六進位加法。十進位的 12 等於十六進位的 <code>0xC</code>。</p>
                        <pre><code class="language-text">  0x5678
+ 0x000C
--------
  0x5684</code></pre>
                        <p>因此，第 4 個元素的位址是 <code>0x5684</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q28">下一題</button></div>
                </div>

                <div id="q28" class="quiz-card">
                    <h3>28. 在 C 語言中，宣告一個單精度浮點數的陣列，該陣列的第 1 個元素位址為 0x45ED，則其第 3 個元素的位址為何？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 0x45EE</div>
                        <div class="option" data-option="B">(B) 0x45F1</div>
                        <div class="option" data-option="C">(C) 0x45F5</div>
                        <div class="option" data-option="D">(D) 0x45F9</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：陣列元素位址計算 (float)</h4>
                        <p><b>1. 陣列元素與索引：</b></p>
                        <p>「第 1 個元素」是索引 0 (<code>arr[0]</code>)，「第 3 個元素」是索引 2 (<code>arr[2]</code>)。</p>
                        <p><b>2. 指標算術與資料型態大小：</b></p>
                        <p>位址 of <code>arr[i] = base_address + i * sizeof(element_type)</code>。</p>
                        <p>題目給定：</p>
                        <ul>
                            <li>陣列是「單精度浮點數」陣列。單精度浮點數是 <code>float</code> 型別。</li>
                            <li><code>sizeof(float)</code> 通常是 4 bytes。</li>
                            <li>第 1 個元素 (<code>arr[0]</code>) 的位址是 <code>0x45ED</code>。</li>
                        </ul>
                        <p>我們要找的是第 3 個元素 (即 <code>arr[2]</code>) 的位址。所以 <code>i = 2</code>。</p>
                        <p>位址 of <code>arr[2]</code> = <code>0x45ED + 2 * sizeof(float)</code></p>
                        <p>位址 of <code>arr[2]</code> = <code>0x45ED + 2 * 4</code> bytes</p>
                        <p>位址 of <code>arr[2]</code> = <code>0x45ED + 8</code> bytes</p>
                        <p>進行十六進位加法。十進位的 8 等於十六進位的 <code>0x8</code>。</p>
                        <pre><code class="language-text">  0x45ED
+ 0x0008
--------
  0x45F5  (D+8 = 13+8 = 21. 21 in hex is 15. So E_hex + 8_hex = 16+5 = 21_dec = 15_hex. So D becomes 5, carry 1 to E. E+1 = F)</code></pre>
                        <p>因此，第 3 個元素的位址是 <code>0x45F5</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q29">下一題</button></div>
                </div>

                <div id="q29" class="quiz-card">
                    <h3>29. 在 C 語言中，宣告一個雙精度浮點數的陣列，該陣列的第 1 個元素位址為 0xEA50，則其第 5 個元素的位址為何？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 0xEA54</div>
                        <div class="option" data-option="B">(B) 0xEA58</div>
                        <div class="option" data-option="C">(C) 0xEA60</div>
                        <div class="option" data-option="D">(D) 0xEA70</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：陣列元素位址計算 (double)</h4>
                        <p><b>1. 陣列元素與索引：</b></p>
                        <p>「第 1 個元素」是索引 0 (<code>arr[0]</code>)，「第 5 個元素」是索引 4 (<code>arr[4]</code>)。</p>
                        <p><b>2. 指標算術與資料型態大小：</b></p>
                        <p>位址 of <code>arr[i] = base_address + i * sizeof(element_type)</code>。</p>
                        <p>題目給定：</p>
                        <ul>
                            <li>陣列是「雙精度浮點數」陣列。雙精度浮點數是 <code>double</code> 型別。</li>
                            <li><code>sizeof(double)</code> 通常是 8 bytes。</li>
                            <li>第 1 個元素 (<code>arr[0]</code>) 的位址是 <code>0xEA50</code>。</li>
                        </ul>
                        <p>我們要找的是第 5 個元素 (即 <code>arr[4]</code>) 的位址。所以 <code>i = 4</code>。</p>
                        <p>位址 of <code>arr[4]</code> = <code>0xEA50 + 4 * sizeof(double)</code></p>
                        <p>位址 of <code>arr[4]</code> = <code>0xEA50 + 4 * 8</code> bytes</p>
                        <p>位址 of <code>arr[4]</code> = <code>0xEA50 + 32</code> bytes</p>
                        <p>進行十六進位加法。十進位的 32 等於十六進位的 <code>0x20</code>。</p>
                        <pre><code class="language-text">  0xEA50
+ 0x0020
--------
  0xEA70</code></pre>
                        <p>因此，第 5 個元素的位址是 <code>0xEA70</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q30">下一題</button></div>
                </div>

                <div id="q30" class="quiz-card">
                    <h3>30. 在 C 語言中，宣告一個二維陣列 int A[2][2]，該陣列的第 1 個元素為 0x4D12，則其最後一個元素的位址為何？</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 0x4D1F</div>
                        <div class="option" data-option="B">(B) 0x4D1E</div>
                        <div class="option" data-option="C">(C) 0x4D1A</div>
                        <div class="option" data-option="D">(D) 0x4D16</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：二維陣列元素位址計算</h4>
                        <p>陣列 <code>int A[2][2]</code> 是一個 2x2 的整數陣列。其元素在記憶體中是連續儲存的，通常採用列優先 (row-major) 順序。</p>
                        <p>元素順序： <code>A[0][0]</code>, <code>A[0][1]</code>, <code>A[1][0]</code>, <code>A[1][1]</code>。</p>
                        <p>題目給定：</p>
                        <ul>
                            <li>第 1 個元素 (<code>A[0][0]</code>) 的位址是 <code>0x4D12</code>。</li>
                            <li>假設 <code>sizeof(int) = 4</code> bytes (常見大小)。</li>
                        </ul>
                        <p>我們要找的是「最後一個元素」的位址，即 <code>A[1][1]</code> 的位址。</p>
                        <p><code>A[1][1]</code> 是從 <code>A[0][0]</code> 開始的第幾個元素？</p>
                        <ul>
                            <li><code>A[0][0]</code> - 第 0 個元素 (相對於起始)</li>
                            <li><code>A[0][1]</code> - 第 1 個元素</li>
                            <li><code>A[1][0]</code> - 第 2 個元素</li>
                            <li><code>A[1][1]</code> - 第 3 個元素</li>
                        </ul>
                        <p>所以，<code>A[1][1]</code> 是相對於陣列起始位置的第 3 個元素 (索引從0開始算，所以是偏移量為3)。</p>
                        <p>位址 of <code>A[1][1]</code> = (位址 of <code>A[0][0]</code>) + <code>3 * sizeof(int)</code></p>
                        <p>位址 of <code>A[1][1]</code> = <code>0x4D12 + 3 * 4</code> bytes</p>
                        <p>位址 of <code>A[1][1]</code> = <code>0x4D12 + 12</code> bytes</p>
                        <p>進行十六進位加法。十進位的 12 等於十六進位的 <code>0xC</code>。</p>
                        <pre><code class="language-text">  0x4D12
+ 0x000C
--------
  0x4D1E</code></pre>
                        <p>因此，最後一個元素 <code>A[1][1]</code> 的位址是 <code>0x4D1E</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q31">下一題</button></div>
                </div>

                <div id="q31" class="quiz-card">
                    <h3>31. 在 C 語言中，宣告一個三維陣列 int G[2][2][2]，該陣列的第 1 個元素為 0x98E2，則其最後一個元素的位址為何？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 0x9906</div>
                        <div class="option" data-option="B">(B) 0x9902</div>
                        <div class="option" data-option="C">(C) 0x98FE</div>
                        <div class="option" data-option="D">(D) 0x98FA</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：三維陣列元素位址計算</h4>
                        <p>陣列 <code>int G[2][2][2]</code> 是一個 2x2x2 的整數陣列。</p>
                        <p>總元素個數 = <code>2 * 2 * 2 = 8</code> 個元素。</p>
                        <p>元素在記憶體中以列優先 (row-major like) 順序連續儲存。索引從 0 開始：</p>
                        <p><code>G[0][0][0], G[0][0][1], G[0][1][0], G[0][1][1], G[1][0][0], G[1][0][1], G[1][1][0], G[1][1][1]</code></p>
                        <p>題目給定：</p>
                        <ul>
                            <li>第 1 個元素 (<code>G[0][0][0]</code>) 的位址是 <code>0x98E2</code>。</li>
                            <li>假設 <code>sizeof(int) = 4</code> bytes。</li>
                        </ul>
                        <p>我們要找的是「最後一個元素」的位址，即 <code>G[1][1][1]</code> 的位址。</p>
                        <p><code>G[1][1][1]</code> 是從 <code>G[0][0][0]</code> 開始的第幾個元素？ 它是第 8 個元素，但索引是 7 (因為從0開始)。</p>
                        <p>所以，<code>G[1][1][1]</code> 是相對於陣列起始位置的第 7 個元素 (索引從0開始算，所以是偏移量為7)。</p>
                        <p>位址 of <code>G[1][1][1]</code> = (位址 of <code>G[0][0][0]</code>) + <code>7 * sizeof(int)</code></p>
                        <p>位址 of <code>G[1][1][1]</code> = <code>0x98E2 + 7 * 4</code> bytes</p>
                        <p>位址 of <code>G[1][1][1]</code> = <code>0x98E2 + 28</code> bytes</p>
                        <p>進行十六進位加法。十進位的 28 等於十六進位的 <code>0x1C</code> (16*1 + 12)。</p>
                        <pre><code class="language-text">  0x98E2
+ 0x001C
--------
  0x98FE  (2+C=2+12=14 -> E_hex; E+1=14+1=15 -> F_hex)</code></pre>
                        <p>因此，最後一個元素 <code>G[1][1][1]</code> 的位址是 <code>0x98FE</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q32">下一題</button></div>
                </div>

                <div id="q32" class="quiz-card">
                    <h3>32.  下列對於 C 語言指標的描述是錯誤的？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 指標變數存放某變數的位址</div>
                        <div class="option" data-option="B">(B) 陣列名稱就是該陣列第 1 個元素的指標</div>
                        <div class="option" data-option="C">(C) 指標就是位址</div>
                        <div class="option" data-option="D">(D) 指標的值一定是整數</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C 語言指標特性</h4>
                        <ul>
                            <li><b>(A) 指標變數存放某變數的位址：</b>正確。這正是指標變數的定義和用途。</li>
                            <li><b>(B) 陣列名稱就是該陣列第 1 個元素的指標：</b>正確。在大多數表達式中，陣列名稱會衰變 (decay) 為指向其第一個元素的指標。</li>
                            <li><b>(C) 指標就是位址：</b>可以這麼理解。一個指標變數儲存的是一個記憶體位址。指標的「值」就是它所儲存的那個位址。</li>
                            <li><b>(D) 指標的值一定是整數：</b>**錯誤**。雖然記憶體位址在底層通常是以無符號整數的形式表示的，但在 C 語言的型別系統中，指標有其自身的型別 (例如 <code>int*</code>, <code>char*</code>, <code>void*</code> 等)，它與普通的整數型別 (<code>int</code>, <code>long</code>) 是不同的。不能隨意將一個整數賦值給指標變數（除非進行強制型別轉換，且通常這樣做是不安全的，除非你知道該整數確實是一個有效的記憶體位址）。指標的值是一個位址，這個位址的「數值表示」可以是整數，但指標型別本身不是簡單的整數型別。例如，對指標進行算術運算 (如 <code>ptr+1</code>) 時，其行為是根據所指向的資料型別大小來調整的，而不是簡單的整數加1。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q33">下一題</button></div>
                </div>

                <div id="q33" class="quiz-card">
                    <h3>33.  下列對於 C 語言指標的描述是錯誤的？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 指標一定要指定某個位址後才能使用</div>
                        <div class="option" data-option="B">(B) 指標可以進行++或--運算</div>
                        <div class="option" data-option="C">(C) 指標未使用時，最好指定為 NULL</div>
                        <div class="option" data-option="D">(D) 指標變數可以直接指定一個常數</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C 語言指標特性與使用</h4>
                        <ul>
                            <li><b>(A) 指標一定要指定某個位址後才能使用：</b>「使用」通常指解參考 (dereferencing, <code>*ptr</code>)。對一個未初始化或指向無效位址的指標進行解參考是未定義行為，非常危險。所以，為了安全地解參考一個指標，它必須先指向一個有效的記憶體位置。此敘述是正確的。</li>
                            <li><b>(B) 指標可以進行++或--運算：</b>正確。指標支援遞增 (<code>++</code>) 和遞減 (<code>--</code>) 運算。這些運算會使指標指向下一個或前一個同型別元素的記憶體位置 (即位址會增加或減少 <code>sizeof(pointed_type)</code>)。</li>
                            <li><b>(C) 指標未使用時，最好指定為 NULL：</b>正確。將未使用的指標或不再指向有效記憶體的指標設為 <code>NULL</code> (通常是定義為 <code>(void*)0</code> 的巨集) 是一種良好的程式設計習慣。這有助於防止意外解參考野指標 (wild pointers)，並且可以在使用前檢查指標是否為 <code>NULL</code>。</li>
                            <li><b>(D) 指標變數可以直接指定一個常數：</b>**錯誤**。指標變數儲存的是記憶體位址。你不能直接將一個普通的整數常數 (如 <code>100</code>, <code>0x1234</code>) 賦值給一個指標變數，除非進行強制型別轉換 (casting)，例如 <code>int *ptr = (int*)0x1234;</code>。即使如此，直接將任意整數賦值給指標也是非常危險的，因為你無法保證該整數代表一個有效的、程式可存取的記憶體位址。唯一的例外是空指標常數 <code>NULL</code> (或字面值 <code>0</code>)，它可以被賦值給任何型別的指標。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q34">下一題</button></div>
                </div>
                <!-- ... Questions 34-77 would follow, applying the new explanation style for arrays/pointers
                     and loop tracking tables where appropriate ... -->
                 <div id="q77" class="quiz-card"> <!-- Example of last question in this file -->
                    <h3>77. 下列為 c 語言的一段程式，其中 int ＊p 表示 p 為一個指向整數的指標，int b 表示 b 是一個整數，則下列何者正確？</h3>
                    <pre><code class="language-c">int *p;
int b;
b = p/3;
printf("answer=%f", b);</code></pre>
                    <button class="run-example-btn" data-code-id="q77-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A)	程式在執行之後會在螢幕上輸出指標 p 的 1/3 且四捨五入之後的數值</div>
                        <div class="option" data-option="B">(B)	程式在經過編譯器(compiler)的翻譯過程中會出現 b = p/3 那一行資料型態不一致錯誤訊息</div>
                        <div class="option" data-option="C">(C)程式在執行完之後會在螢幕上輸出指標 p 所指向的整數的 1/3 且四捨五入之後的數值</div>
                        <div class="option" data-option="D">(D)程式在經過直譯器(Interpreter)的翻譯過程中會出現 printf("answer=%f"， b)那一行資料結構不一致的冨告訊息</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：指標運算與型別錯誤</h4>
                        <p>分析程式碼片段：</p>
                        <ol>
                            <li><code>int *p;</code>：宣告一個指向整數的指標 <code>p</code>。此時 <code>p</code> 未被初始化。</li>
                            <li><code>int b;</code>：宣告一個整數變數 <code>b</code>，也未初始化。</li>
                            <li><code>b = p/3;</code>：<b>主要錯誤點</b>。
                                <ul>
                                    <li>指標 <code>p</code> 未初始化，使用其值是未定義行為。</li>
                                    <li>C 語言不支援指標直接進行除法運算。這會導致編譯錯誤。</li>
                                </ul>
                            </li>
                            <li><code>printf("answer=%f", b);</code>：
                                <ul>
                                    <li>如果程式能編譯通過前一步，這行也有問題。<code>%f</code> 用於輸出浮點數，而 <code>b</code> 是 <code>int</code>。型別不匹配會導致未定義行為。</li>
                                </ul>
                            </li>
                        </ol>
                        <p>分析選項：</p>
                        <ul>
                            <li><b>(A) ...輸出指標 p 的 1/3...：</b>錯誤。</li>
                            <li><b>(B) ...編譯過程中會出現 b = p/3 那一行資料型態不一致錯誤訊息：</b>正確。</li>
                            <li><b>(C) ...輸出指標 p 所指向的整數的 1/3...：</b>錯誤。</li>
                            <li><b>(D) ...直譯器(Interpreter)...：</b>錯誤，C 是編譯型語言。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q1">回到第一題</button></div>
                </div>
                <!-- QUIZ CARDS END -->
            </div>
        </main>

        <div class="resizer" id="dragMe"></div>

        <aside class="interactive-panel">
            <div class="interactive-panel-inner">
                <div class="sandbox-container">
                    <h3>C 語言程式碼沙箱 (WASM)</h3>
                    <textarea id="code-editor" spellcheck="false">#include &lt;stdio.h&gt;

int main() {
  // Default code or code from the first runnable example for this part
  printf("Hello from bb5-2.php!\\nSelect a question example or write your own code.\\n");
  return 0;
}</textarea>
                    <div class="sandbox-controls">
                        <button id="run-code-btn">編譯與執行</button>
                    </div>
                    <pre id="output-area" aria-live="polite">輸出結果將顯示於此...</pre>
                </div>
            </div>
        </aside>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const codeSamples = { // Only samples for Q27-Q52
                'q31_32-code': `#include <stdio.h>\n\n#define Value1  100\n#define Value2 (Value1 - 1)\n\nint main() {\n  int Value3_q32; \n  int CheckValue = 0;\n  Value3_q32 = Value2;\n  CheckValue = Value1 + Value3_q32;\n  printf("Value1: %d\\nValue2: %d\\nValue3_q32: %d\\nCheckValue: %d\\n", Value1, Value2, Value3_q32, CheckValue);\n  return 0;\n}`,
                'q36-code': `#include <stdio.h>\n\nint main() {\n    int item=5;\n    int T[]={2,4,6,8,10,12};\n    int S[item]; \n    for (int m=0;m<item;m++){ S[m]=T[m];}\n    printf("%d\\n", T[T[0]+1]+2);\n    return 0;\n}`,
                'q37-code': `#include <stdio.h>\n\nint main() {\n    int Y[3][3];\n    for (int i=0;i<3;i++){ for (int j=0;j<3;j++){ Y[i][j]=(i+1)*(j+1);}}\n    printf("Y[1][2] = %d\\n", Y[1][2]);\n    printf("Y[2][1] = %d\\n", Y[2][1]);\n    return 0;\n}`,
                'q38-code': `#include <stdio.h>\n\nint main() {\n    int M[]={10,20,30,40,50,60};\n    int N[2][3];\n    int k=0;\n    for (int i=0;i<3;i++){ for (int j=0;j<2;j++){ N[j][i]=M[k]; k++;}}\n    printf("N[1][2] = %d\\n", N[1][2]);\n    return 0;\n}`,
                'q39-code': `#include <stdio.h>\n\nint main() {\n    int s1=0, s2=1;\n    int K[]={90,25,64,87,12,49};\n    for  (int  i=0;i<6;i++){ if (K[i]>70) s1=s1+1; if (K[i]<60) s2=s2+1;}\n    printf("%d\\n", s1*s2);\n    return 0;\n}`,
                'q40-code': `#include <stdio.h>\n\nint main() {\n    int a, sum=0;\n    int F[]={1,-2,3,-4,5};\n    for (int i=0;i<5;i++){ a=F[i]; if (a>0) a=0-a; sum=sum+a;}\n    printf("%d\\n", sum);\n    return 0;\n}`,
                'q41-code': `#include <stdio.h>\n\nint main() {\n    int w[5] = {21, 65, 7, 19, 47};\n    int t;\n    for (int i=1; i<5; i++){ if (w[i]<w[i-1]){ t=w[i]; w[i] = w[i-1]; w[i-1] = t;}}\n    printf("w[4] = %d\\n", w[4]);\n    return 0;\n}`,
                'q42-code': `#include <stdio.h>\n\nint main() {\n    int w[5] = {21, 65, 7, 19, 47};\n    int t;\n    for (int i=1; i<5; i++){ if (w[i]>w[i-1]){ t=w[i]; w[i] = w[i-1]; w[i-1] = t;}}\n    printf("w[4] = %d\\n", w[4]);\n    return 0;\n}`,
                'q43-code': `#include <stdio.h>\n\nint main() {\n    int w[5] = {21, 65, 7, 19, 47};\n    int t;\n    for (int i=1; i<5; i++){ if (w[0]>w[i]){ t=w[0]; w[0]=w[i]; w[i]=t;}}\n    printf("w[0] = %d\\n", w[0]);\n    return 0;\n}`,
                'q44-code': `#include <stdio.h>\n\nint main() {\n    int w[5] = {21, 65, 7, 19, 47};\n    int t;\n    for (int i=1; i<5; i++){ if (w[0]<w[i]){ t=w[0]; w[0]=w[i]; w[i]=t;}}\n    printf("w[0] = %d\\n", w[0]);\n    return 0;\n}`,
                'q45-code': `#include <stdio.h>\n\nint main() {\n    int data[5]={20,18,87,6,32};\n    int i, j, tmp;\n    for (i=3;i>=0;i--){ for (j=0;j<=i;j++){ if(data[j]>data[j+1]){ tmp=data[j]; data[j]=data[j+1]; data[j+1]=tmp;}}}\n    printf("data[2] = %d\\n", data[2]);\n    return 0;\n}`,
                'q46-code': `#include <stdio.h>\n\nint main() {\n    int data[5]={20,18,87,6,32};\n    int i, j, tmp;\n    for (i=3;i>=0;i--){ for (j=0;j<=i;j++){ if(data[j]<data[j+1]){ tmp=data[j]; data[j]=data[j+1]; data[j+1]=tmp;}}}\n    for (i=0;i<5;i++){ printf("%d ", data[i]);}\n    printf("\\n");\n    return 0;\n}`,
                'q47-code': `#include <stdio.h>\n\nint main() {\n    int A[3][3] = {{1,2,3},{4,5,6},{7,8,9}};\n    int result = 0;\n    for (int i=0;i<3;i++){ for (int j=0;j<3;j++){ if (i==j) result = result + A[i][j]*2; else result = result +A[i][j];}}\n    printf("result = %d\\n", result);\n    return 0;\n}`,
                'q48-code': `#include <stdio.h>\n\nint main() {\n    int L[]={11,22,33,44,55,66,77,88,99};\n    int len=-1; \n    len=sizeof(L)/sizeof(L[0]); \n    printf("%d\\n", len);\n    return 0;\n}`,
                'q49-code': `#include <stdio.h>\n\nint main() {\n    int *ptr, y=5;\n    ptr = &y; \n    *ptr = 10; \n    printf("%d,%d\\n", *ptr, y);\n    return 0;\n}`,
                'q50-code': `#include <stdio.h>\n\nint main() {\n    int *ptr, y=5;\n    ptr = &y;\n    printf("%d", y); \n    *ptr = 10;     \n    printf(",%d", y); \n    printf("\\n");\n    return 0;\n}`,
                'q51-code': `#include <stdio.h>\n\nint main() {\n    int d=100;\n    int *p;\n    p = &d;    \n    *p = *p * 5; \n    printf("d = %d\\n", d);\n    return 0;\n}`,
                'q52-code': `#include <stdio.h>\n\nint main() {\n    int m=5, n=6, tmp;\n    int *p1, *p2;\n    p1=&m; \n    p2=&n; \n    tmp=*p1; \n    *p1=*p2; \n    *p2=tmp; \n    printf("m=%d, n=%d\\n", m, n);\n    return 0;\n}`
            };

            const codeEditor = document.getElementById('code-editor');
            const outputArea = document.getElementById('output-area');
            const runCodeBtn = document.getElementById('run-code-btn');

            document.querySelectorAll('.run-example-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const codeId = button.getAttribute('data-code-id');
                    if (codeSamples[codeId]) {
                        codeEditor.value = codeSamples[codeId];
                        outputArea.textContent = '程式碼已載入。點擊「編譯與執行」來查看結果。';
                        document.querySelector('.interactive-panel').scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });

            runCodeBtn.addEventListener('click', async () => {
                outputArea.textContent = '編譯中，請稍候...';
                runCodeBtn.disabled = true;
                const oldIframe = document.getElementById('emcc-sandbox');
                if (oldIframe) oldIframe.remove();
                const code = codeEditor.value;
                try {
                    const backendUrl = 'http://c.ksvs.kh.edu.tw:3000/compile';
                    const resp = await fetch(backendUrl, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: new URLSearchParams({ code })
                    });
                    if (!resp.ok) {
                        const errorText = await resp.text();
                        throw new Error(`編譯失敗 (HTTP ${resp.status}):\n${errorText}`);
                    }
                    const { js, wasm } = await resp.json();
                    if (!js || !wasm) throw new Error('後端回應格式不正確，未包含 JS 或 WASM 資料。');
                    outputArea.textContent = '執行中...\n\n▶ 執行結果:\n';
                    const mainJsText = atob(js);
                    const mainWasmBinary = Uint8Array.from(atob(wasm), c => c.charCodeAt(0));
                    const iframe = document.createElement('iframe');
                    iframe.id = 'emcc-sandbox';
                    iframe.style.display = 'none';
                    iframe.onload = () => {
                        const iframeWindow = iframe.contentWindow;
                        iframeWindow.EMCC_JS_CODE = mainJsText;
                        iframeWindow.EMCC_WASM_BINARY = mainWasmBinary;
                        iframeWindow.parentPrint = (text) => { outputArea.textContent += text + '\n'; };
                        iframeWindow.parentPrintError = (text) => { outputArea.textContent += `[錯誤]: ${text}\n`; };
                        iframeWindow.parentSignalEnd = () => {
                            outputArea.textContent += '\n--- 執行完畢 ---';
                            iframe.remove();
                            runCodeBtn.disabled = false;
                        };
                        const bootstrapScript = iframe.contentDocument.createElement('script');
                        bootstrapScript.textContent = `
                            window.Module = {
                                wasmBinary: window.EMCC_WASM_BINARY,
                                print: (text) => window.parentPrint(text),
                                printErr: (text) => window.parentPrintError(text),
                                onRuntimeInitialized: () => {},
                                onExit: () => { window.parentSignalEnd(); }
                            };
                            const scriptElement = document.createElement('script');
                            scriptElement.textContent = window.EMCC_JS_CODE;
                            document.body.appendChild(scriptElement);
                        `;
                        iframe.contentDocument.body.appendChild(bootstrapScript);
                    };
                    document.body.appendChild(iframe);
                } catch (e) {
                    outputArea.textContent = '請求或執行時發生錯誤：\n\n' + e.message + '\n\n請確認您的本機後端編譯服務 (http://c.ksvs.kh.edu.tw:3000/compile) 已正確啟動。';
                    runCodeBtn.disabled = false;
                }
            });

            document.querySelectorAll('.quiz-options').forEach(optionsContainer => {
                optionsContainer.addEventListener('click', function(e) {
                    if (e.target.classList.contains('option') && !this.classList.contains('answered')) {
                        const selectedOption = e.target;
                        const correctAnswer = this.getAttribute('data-correct');
                        const selectedAnswer = selectedOption.getAttribute('data-option');
                        this.classList.add('answered');
                        this.querySelectorAll('.option').forEach(opt => {
                           const optValue = opt.getAttribute('data-option');
                           const feedbackIcon = document.createElement('span');
                           feedbackIcon.classList.add('feedback-icon');
                           if(optValue === correctAnswer){
                               opt.classList.add('correct');
                               feedbackIcon.textContent = ' ✅';
                           } else if (optValue === selectedAnswer) {
                               opt.classList.add('incorrect');
                               feedbackIcon.textContent = ' ❌';
                           }
                           if (opt === selectedOption || optValue === correctAnswer) {
                                if(opt.querySelector('.feedback-icon') == null) {
                                   opt.appendChild(feedbackIcon);
                                }
                           }
                           opt.classList.add('answered');
                        });
                        const explanation = this.closest('.quiz-card').querySelector('.explanation');
                        if (explanation) explanation.style.display = 'block';
                    }
                });
            });

            document.querySelectorAll('.next-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            const resizer = document.getElementById('dragMe');
            const leftSide = document.querySelector('.tutorial-content');
            const mouseDownHandler = function (e) {
                resizer.classList.add('is-dragging');
                const x = e.clientX;
                const leftWidth = leftSide.getBoundingClientRect().width;
                const overlay = document.createElement('div');
                overlay.style.position = 'fixed';
                overlay.style.top = '0';
                overlay.style.left = '0';
                overlay.style.width = '100%';
                overlay.style.height = '100%';
                overlay.style.cursor = 'col-resize';
                overlay.style.zIndex = '9999';
                document.body.appendChild(overlay);
                document.addEventListener('mousemove', mouseMoveHandler);
                document.addEventListener('mouseup', mouseUpHandler);
                function mouseMoveHandler(e_move) {
                    const dx = e_move.clientX - x;
                    const newLeftWidth = leftWidth + dx;
                    if (newLeftWidth > 200 && newLeftWidth < (document.body.clientWidth - 250)) {
                       leftSide.style.width = `${newLeftWidth}px`;
                    }
                }
                function mouseUpHandler() {
                    resizer.classList.remove('is-dragging');
                    document.body.removeChild(overlay);
                    document.removeEventListener('mousemove', mouseMoveHandler);
                    document.removeEventListener('mouseup', mouseUpHandler);
                }
            };
            resizer.addEventListener('mousedown', mouseDownHandler);

            if (Object.keys(codeSamples).length > 0) { // Check if codeSamples is not empty
                 codeEditor.value = codeSamples[Object.keys(codeSamples)[0]];
            } else {
                 codeEditor.value = "// Welcome! No runnable examples in this section. Write your own C/C++ code here.";
            }
        });
    </script>
</body>
</html>
