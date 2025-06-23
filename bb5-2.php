<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C 語言 第四章 Part 2: 陣列與指標進階</title>

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
            <h1>C 語言練習：第四章 Part 2 - 陣列與指標進階應用</h1>
            <p>本頁面為 C/C++ 語言第四章練習題的第二部分 (第 21-44 題)，著重於陣列、指標的進階操作與綜合應用。請仔細分析每個題目，並利用右側的沙箱進行實作與驗證。詳解將提供深入的步驟分析和概念釐清，包括詳細的表格追蹤。</p>

            <div class="quiz-section">
                <h2>第四章 互動練習題組 (2/3)</h2>
                <p>請挑戰下面的題目，檢驗您的學習成果！</p>
                <!-- QUIZ CARDS START -->
                <div id="q21" class="quiz-card">
                    <h3>21. 宣告一陣列 int arr[4]={0,1,2,3}，則*arr 的值為何？</h3>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 0</div>
                        <div class="option" data-option="B">(B) 1</div>
                        <div class="option" data-option="C">(C) 2</div>
                        <div class="option" data-option="D">(D) 3</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：陣列名稱與指標解參考</h4>
                        <p><b>1. 依陣列解釋</b></p>
                        <p>陣列 <code>int arr[4]={0,1,2,3};</code> 的元素為：</p>
                        <p><code>arr[0]=0, arr[1]=1, arr[2]=2, arr[3]=3</code></p>
                        <p><b>2. 依指標解釋</b></p>
                        <p>陣列名稱 <code>arr</code> 在表達式中通常會衰變 (decay) 為指向其第一個元素 (<code>arr[0]</code>) 的指標。所以 <code>arr</code> 的值等同於 <code>&amp;arr[0]</code>。</p>
                        <p>運算子 <code>*</code> 是解參考運算子。當作用於一個指標時，它會取得該指標所指向的記憶體位置的內容 (值)。</p>
                        <p>因此，<code>*arr</code> 等價於 <code>*(&amp;arr[0])</code>，也就是 <code>arr[0]</code> 的值。</p>
                        <p><b>3. 題目選項解析：</b></p>
                        <p>由於 <code>arr[0]</code> 的值是 0，所以 <code>*arr</code> 的值也是 0。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q22">下一題</button></div>
                </div>

                <div id="q22" class="quiz-card">
                    <h3>22. 某整數陣列 K[10]，下列哪一行敘述可以取得該陣列的元素個數？</h3>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) sizeof(K)/sizeof(K[0])</div>
                        <div class="option" data-option="B">(B) sizeof(K)</div>
                        <div class="option" data-option="C">(C) K[9]-K[0]</div>
                        <div class="option" data-option="D">(D) *K</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：計算陣列元素個數</h4>
                        <p>在 C 語言中，要取得一個靜態宣告陣列的元素個數，常用的方法是：</p>
                        <p><code>元素個數 = sizeof(整個陣列) / sizeof(陣列中的一個元素)</code></p>
                        <ul>
                            <li><code>sizeof(K)</code>：會回傳整個陣列 <code>K</code> 所佔用的總位元組數。如果 <code>K</code> 是 <code>int K[10]</code> 且 <code>sizeof(int)</code> 為 4 bytes，則 <code>sizeof(K)</code> 為 <code>10 * 4 = 40</code> bytes。</li>
                            <li><code>sizeof(K[0])</code>：會回傳陣列 <code>K</code> 中第一個元素 (<code>K[0]</code>) 所佔用的位元組數。由於 <code>K</code> 是整數陣列，<code>K[0]</code> 是一個整數，所以 <code>sizeof(K[0])</code> 等於 <code>sizeof(int)</code>，即 4 bytes (假設)。</li>
                        </ul>
                        <p>分析選項：</p>
                        <ul>
                            <li><b>(A) sizeof(K)/sizeof(K[0])：</b>正確。這是標準的計算陣列元素個數的方法。例如，<code>40 bytes / 4 bytes = 10</code> 個元素。</li>
                            <li><b>(B) sizeof(K)：</b>不正確。這只給出陣列的總位元組大小，不是元素個數。</li>
                            <li><b>(C) K[9]-K[0]：</b>不正確。這是計算陣列最後一個元素與第一個元素的值的差，與元素個數無關。</li>
                            <li><b>(D) *K：</b>不正確。<code>*K</code> 等價於 <code>K[0]</code>，是陣列第一個元素的值，不是元素個數。</li>
                        </ul>
                        <p>注意：此方法僅適用於靜態宣告的陣列，其大小在編譯時期可知。如果陣列是透過指標傳遞給函數的，則在函數內部 <code>sizeof(pointer_name)</code> 只會得到指標本身的大小，而不是原始陣列的大小。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q23">下一題</button></div>
                </div>

                <div id="q23" class="quiz-card">
                    <h3>23. 在 C 語言中，要取得某變數的記憶體位址，要使用哪一個運算子？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) *</div>
                        <div class="option" data-option="B">(B) **</div>
                        <div class="option" data-option="C">(C) &amp;</div>
                        <div class="option" data-option="D">(D) &amp;&amp;</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C 語言運算子</h4>
                        <ul>
                            <li><b>(A) * (星號)：</b>作為一元運算子時，是解參考運算子 (Dereference/Indirection operator)，用於取得指標所指向位址的「內容」(值)。作為二元運算子時，是乘法。</li>
                            <li><b>(B) ** (雙星號)：</b>不是 C 語言的標準一元或二元運算子。在指標宣告中 <code>int **p;</code> 表示指向指標的指標。</li>
                            <li><b>(C) &amp; (앰퍼샌드)：</b>作為一元運算子時，是取址運算子 (Address-of operator)，用於取得變數的記憶體位址。作為二元運算子時，是位元 AND。</li>
                            <li><b>(D) &amp;&amp; (雙앰퍼샌드)：</b>是邏輯 AND (Logical AND) 運算子，用於布林邏輯。</li>
                        </ul>
                        <p>題目要求取得變數的「記憶體位址」，因此應使用取址運算子 <code>&amp;</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q24">下一題</button></div>
                </div>

                <div id="q24" class="quiz-card">
                    <h3>24. 在 C 語言中宣告一個有 10 個元素的整數陣列，請問該陣列佔用的記憶體空間大小？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 10Byte</div>
                        <div class="option" data-option="B">(B) 20Byte</div>
                        <div class="option" data-option="C">(C) 40Byte</div>
                        <div class="option" data-option="D">(D) 80Byte</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：陣列記憶體大小</h4>
                        <p>宣告一個有 10 個元素的整數陣列，例如 <code>int arr[10];</code>。</p>
                        <p>總記憶體空間 = 元素個數 × 每個元素的大小 (<code>sizeof(int)</code>)。</p>
                        <p>題目沒有明確給出 <code>int</code> 的大小，但 C 語言中 <code>int</code> 通常占用 4 bytes (32 bits) 在常見的現代系統上。這是最普遍的假設，尤其在程式設計競賽或測驗中，除非另有說明。</p>
                        <p>假設 <code>sizeof(int) = 4 bytes</code>：</p>
                        <p>總記憶體空間 = <code>10 * 4 bytes = 40 bytes</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q25">下一題</button></div>
                </div>

                <div id="q25" class="quiz-card">
                    <h3>25. 在 C 語言中宣告一個有 100 個元素的整數陣列，其最大和最小的索引值分別為多少？</h3>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 99,0</div>
                        <div class="option" data-option="B">(B) 100,1</div>
                        <div class="option" data-option="C">(C) 0,99</div>
                        <div class="option" data-option="D">(D) 1,100</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：陣列索引範圍</h4>
                        <p>在 C 語言中，陣列索引是從 0 開始的 (0-based indexing)。</p>
                        <p>如果一個陣列宣告為有 <code>N</code> 個元素，例如 <code>int arr[N];</code>，那麼：</p>
                        <ul>
                            <li>最小的合法索引值是 <code>0</code>。</li>
                            <li>最大的合法索引值是 <code>N - 1</code>。</li>
                        </ul>
                        <p>題目中宣告了一個有 100 個元素的整數陣列 (<code>N = 100</code>)。</p>
                        <ul>
                            <li>最小索引值 = <code>0</code>。</li>
                            <li>最大索引值 = <code>100 - 1 = 99</code>。</li>
                        </ul>
                        <p>題目問的是「最大和最小的索引值分別為多少」。選項 (A) "99,0" 符合此順序（最大, 最小）。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q26">下一題</button></div>
                </div>

                <div id="q26" class="quiz-card">
                    <h3>26. 在 C 語言中宣告一個 4 列 5 行的整數陣列，請問該陣列佔用的記憶體空間大小？</h3>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 80</div>
                        <div class="option" data-option="B">(B) 60</div>
                        <div class="option" data-option="C">(C) 40</div>
                        <div class="option" data-option="D">(D) 20 Byte</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：二維陣列記憶體大小</h4>
                        <p>宣告一個 4 列 5 行的整數陣列，例如 <code>int arr[4][5];</code>。</p>
                        <p>元素總數 = <code>列數 × 行數 = 4 * 5 = 20</code> 個元素。</p>
                        <p>假設 <code>sizeof(int) = 4 bytes</code> (常見大小)。</p>
                        <p>總記憶體空間 = 元素總數 × <code>sizeof(int)</code> = <code>20 * 4 bytes = 80 bytes</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q27">下一題</button></div>
                </div>

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
                        <p><b>1. 依陣列解釋</b></p>
                        <p>陣列索引從0開始。「第1個元素」是索引0，「第4個元素」是索引3。</p>
                        <p><b>2. 依指標解釋</b></p>
                        <p>位址 of <code>arr[i] = base_address + i * sizeof(element_type)</code>。</p>
                        <p>已知：</p>
                        <ul>
                            <li><code>base_address</code> (<code>&arr[0]</code>) = <code>0x5678</code>。</li>
                            <li><code>element_type</code> 是整數 (<code>int</code>)。假設 <code>sizeof(int) = 4</code> bytes。</li>
                            <li>我們要找第4個元素，即索引 <code>i = 3</code>。</li>
                        </ul>
                        <p>計算：</p>
                        <p>位址 of <code>arr[3]</code> = <code>0x5678 + 3 * 4</code> bytes = <code>0x5678 + 12</code> bytes.</p>
                        <p>十六進位加法: <code>0x5678 + 0xC = 0x5684</code>.</p>
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
                        <p>「第1個元素」是索引0，「第3個元素」是索引2。</p>
                        <p>單精度浮點數 (<code>float</code>) 通常占用 4 bytes (<code>sizeof(float) = 4</code>)。</p>
                        <p><code>base_address = 0x45ED</code>。我們要找索引 <code>i = 2</code> 的位址。</p>
                        <p>位址 of <code>arr[2]</code> = <code>0x45ED + 2 * sizeof(float)</code> = <code>0x45ED + 2 * 4</code> bytes = <code>0x45ED + 8</code> bytes.</p>
                        <p>十六進位加法: <code>0x45ED + 0x8 = 0x45F5</code>.</p>
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
                        <p>「第1個元素」是索引0，「第5個元素」是索引4。</p>
                        <p>雙精度浮點數 (<code>double</code>) 通常占用 8 bytes (<code>sizeof(double) = 8</code>)。</p>
                        <p><code>base_address = 0xEA50</code>。我們要找索引 <code>i = 4</code> 的位址。</p>
                        <p>位址 of <code>arr[4]</code> = <code>0xEA50 + 4 * sizeof(double)</code> = <code>0xEA50 + 4 * 8</code> bytes = <code>0xEA50 + 32</code> bytes.</p>
                        <p>十六進位加法: <code>0xEA50 + 0x20 = 0xEA70</code> (因為十進位32等於十六進位20)。</p>
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
                        <p>陣列 <code>int A[2][2]</code> 元素順序 (列優先): <code>A[0][0], A[0][1], A[1][0], A[1][1]</code>。</p>
                        <p>第1個元素是 <code>A[0][0]</code>，其位址是 <code>0x4D12</code>。</p>
                        <p>最後一個元素是 <code>A[1][1]</code>。</p>
                        <p>假設 <code>sizeof(int) = 4</code> bytes。</p>
                        <p><code>A[1][1]</code> 是相對於 <code>A[0][0]</code> 的第 3 個元素 (索引偏移量為3: (0,0)->0, (0,1)->1, (1,0)->2, (1,1)->3)。</p>
                        <p>位址 of <code>A[1][1]</code> = (位址 of <code>A[0][0]</code>) + <code>3 * sizeof(int)</code> = <code>0x4D12 + 3 * 4</code> bytes = <code>0x4D12 + 12</code> bytes.</p>
                        <p>十六進位加法: <code>0x4D12 + 0xC = 0x4D1E</code>.</p>
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
                        <p>陣列 <code>int G[2][2][2]</code> 總共有 <code>2*2*2 = 8</code> 個元素。</p>
                        <p>第1個元素是 <code>G[0][0][0]</code>，其位址是 <code>0x98E2</code>。</p>
                        <p>最後一個元素是 <code>G[1][1][1]</code>。</p>
                        <p>假設 <code>sizeof(int) = 4</code> bytes。</p>
                        <p><code>G[1][1][1]</code> 是相對於 <code>G[0][0][0]</code> 的第 7 個元素 (索引偏移量為 7)。</p>
                        <p>位址 of <code>G[1][1][1]</code> = (位址 of <code>G[0][0][0]</code>) + <code>7 * sizeof(int)</code> = <code>0x98E2 + 7 * 4</code> bytes = <code>0x98E2 + 28</code> bytes.</p>
                        <p>十六進位加法: <code>0x98E2 + 0x1C = 0x98FE</code> (28<sub>10</sub> = 1C<sub>16</sub>. E2<sub>16</sub> + 1C<sub>16</sub> = (226+28)<sub>10</sub> = 254<sub>10</sub> = FE<sub>16</sub>).</p>
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
                            <li><b>(A) 指標變數存放某變數的位址：</b>正確。</li>
                            <li><b>(B) 陣列名稱就是該陣列第 1 個元素的指標：</b>正確 (在多數表達式中)。</li>
                            <li><b>(C) 指標就是位址：</b>可以這樣理解，指標變數的值是一個位址。</li>
                            <li><b>(D) 指標的值一定是整數：</b>**錯誤**。指標的值是記憶體位址，其底層表示可能是整數，但指標本身具有型別 (如 <code>int*</code>, <code>char*</code>)，與普通整數型別不同，且其算術運算也不同。</li>
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
                            <li><b>(A) 指標一定要指定某個位址後才能使用：</b>正確 (指解參考操作)。</li>
                            <li><b>(B) 指標可以進行++或--運算：</b>正確 (指標算術)。</li>
                            <li><b>(C) 指標未使用時，最好指定為 NULL：</b>正確 (良好習慣)。</li>
                            <li><b>(D) 指標變數可以直接指定一個常數：</b>**錯誤**。不能直接將任意整數常數賦值給指標 (除了 0 或 NULL)，除非進行強制型別轉換，且通常不安全。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q34">下一題</button></div>
                </div>

                <div id="q34" class="quiz-card">
                    <h3>34. 某陣列 arr 的第 1 個元素的位址為 0x1234，下列何者的值為 0x123C？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) arr</div>
                        <div class="option" data-option="B">(B) arr+1</div>
                        <div class="option" data-option="C">(C) arr+2</div>
                        <div class="option" data-option="D">(D) arr+3</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：指標算術</h4>
                        <p>假設 <code>arr</code> 是 <code>int</code> 陣列，<code>sizeof(int) = 4</code> bytes。</p>
                        <p><code>arr</code> (即 <code>&arr[0]</code>) 的位址是 <code>0x1234</code>。</p>
                        <p>我們要找哪個表達式的值是 <code>0x123C</code>。</p>
                        <p><code>0x123C - 0x1234 = 0x8</code> (十進位的 8)。</p>
                        <p>所以，我們需要找到一個表達式，它表示從 <code>arr</code> 的起始位址偏移 8 bytes。</p>
                        <p>由於 <code>sizeof(int) = 4</code>，偏移 8 bytes 意味著偏移 <code>8 / 4 = 2</code> 個整數元素。</p>
                        <p>因此，<code>arr + 2</code> 會得到 <code>0x1234 + 2 * 4 = 0x1234 + 8 = 0x123C</code>。</p>
                        <p><b>選項分析：</b></p>
                        <ul>
                            <li>(A) <code>arr</code>: <code>0x1234</code></li>
                            <li>(B) <code>arr+1</code>: <code>0x1234 + 1*4 = 0x1238</code></li>
                            <li>(C) <code>arr+2</code>: <code>0x1234 + 2*4 = 0x123C</code></li>
                            <li>(D) <code>arr+3</code>: <code>0x1234 + 3*4 = 0x1240</code></li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q35">下一題</button></div>
                </div>

                <div id="q35" class="quiz-card">
                    <h3>35. 宣告某陣列 int arr[4]={1,2,3,4}，下列何者的值與 arr[3]一樣？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) *arr</div>
                        <div class="option" data-option="B">(B) *(arr+1)</div>
                        <div class="option" data-option="C">(C) *(arr+2)</div>
                        <div class="option" data-option="D">(D) *(arr+3)</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：陣列元素存取與指標等價</h4>
                        <p><b>1. 依陣列解釋</b></p>
                        <p>陣列 <code>int arr[4]={1,2,3,4};</code> 的元素及其值：</p>
                        <ul>
                            <li><code>arr[0]</code> = 1</li>
                            <li><code>arr[1]</code> = 2</li>
                            <li><code>arr[2]</code> = 3</li>
                            <li><code>arr[3]</code> = 4</li>
                        </ul>
                        <p>我們需要找到與 <code>arr[3]</code> (其值為 4) 等價的表達式。</p>

                        <p><b>2. 依指標解釋</b></p>
                        <p>陣列名 <code>arr</code> 在表達式中通常衰變為指向其第一個元素 <code>arr[0]</code> 的指標。因此，<code>arr</code> 的值可以看作是 <code>&amp;arr[0]</code>。</p>
                        <p>指標算術：<code>arr + n</code> 指向從 <code>arr</code> 開始的第 <code>n</code> 個元素 (即 <code>&amp;arr[n]</code>)。</p>
                        <p>解參考：<code>*(arr + n)</code> 獲取 <code>arr[n]</code> 的值。</p>

                        <p><b>3. 題目選項解析：等價表示對比</b></p>
                        <p>目標值是 <code>arr[3]</code>，也就是 4。</p>
                        <table>
                            <thead>
                                <tr><th>選項</th><th>展開形式</th><th>解釋</th><th>內容（值）</th><th>是否等於 arr[3] (值為4)?</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>(A) *arr</td><td><code>*(arr + 0)</code></td><td>等於 <code>arr[0]</code></td><td>1</td><td>❌</td></tr>
                                <tr><td>(B) *(arr+1)</td><td><code>*(arr + 1)</code></td><td>等於 <code>arr[1]</code></td><td>2</td><td>❌</td></tr>
                                <tr><td>(C) *(arr+2)</td><td><code>*(arr + 2)</code></td><td>等於 <code>arr[2]</code></td><td>3</td><td>❌</td></tr>
                                <tr><td><b>(D) *(arr+3)</b></td><td><code>*(arr + 3)</code></td><td>等於 <code>arr[3]</code></td><td>4</td><td>✅</td></tr>
                            </tbody>
                        </table>
                        <p><b>关键结论：</b></p>
                        <p><code>arr[3]</code> 的值是 4。表達式 <code>*(arr+3)</code> 也會解參考到 <code>arr[3]</code> 的位置，因此其值也是 4。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q36">下一題</button></div>
                </div>

                <div id="q36" class="quiz-card">
                    <h3>36.  下列程式片段的執行結果為何？</h3>
                    <pre><code class="language-c">int item=5;
int T[]={2,4,6,8,10,12};
int S[item]; // S is int S[5]
for (int m=0;m&lt;item;m++){ S[m]=T[m]; }
// After loop: S = {2,4,6,8,10}
printf("%d", T[T[0]+1]+2);</code></pre>
                    <button class="run-example-btn" data-code-id="q36-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 12</div>
                        <div class="option" data-option="B">(B) 10</div>
                        <div class="option" data-option="C">(C) 8</div>
                        <div class="option" data-option="D">(D) 6</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <ol>
                            <li><code>int item=5;</code></li>
                            <li><code>int T[]={2,4,6,8,10,12};</code> (T[0]=2, T[1]=4, T[2]=6, T[3]=8, T[4]=10, T[5]=12)</li>
                            <li><code>int S[item];</code> 即 <code>int S[5];</code>。</li>
                            <li><code>for (int m=0; m&lt;item; m++){ S[m]=T[m]; }</code>
                                <ul>
                                    <li>m=0: S[0]=T[0]=2</li>
                                    <li>m=1: S[1]=T[1]=4</li>
                                    <li>m=2: S[2]=T[2]=6</li>
                                    <li>m=3: S[3]=T[3]=8</li>
                                    <li>m=4: S[4]=T[4]=10</li>
                                </ul>
                                (陣列 S 現在是 {2,4,6,8,10})
                            </li>
                            <li><code>printf("%d", T[T[0]+1]+2);</code>
                                <ul>
                                    <li><code>T[0]</code> 的值是 2.</li>
                                    <li><code>T[0]+1</code> 等於 <code>2+1 = 3</code>.</li>
                                    <li><code>T[T[0]+1]</code> 等價於 <code>T[3]</code>.</li>
                                    <li><code>T[3]</code> 的值是 8.</li>
                                    <li><code>T[T[0]+1]+2</code> 等價於 <code>8 + 2 = 10</code>.</li>
                                </ul>
                            </li>
                        </ol>
                        <p>因此，程式會印出 10。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q37">下一題</button></div>
                </div>

                <div id="q37" class="quiz-card">
                    <h3>37. 執行下列程式片段後，何者的值與 Y[1][2]相同？</h3>
                    <pre><code class="language-c">int Y[3][3];
for (int i=0;i&lt;3;i++){
    for (int j=0;j&lt;3;j++){
        Y[i][j]=(i+1)*(j+1);
    }
}</code></pre>
                    <button class="run-example-btn" data-code-id="q37-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) Y[2][1]</div>
                        <div class="option" data-option="B">(B) Y[2][2]</div>
                        <div class="option" data-option="C">(C) Y[2][3]</div>
                        <div class="option" data-option="D">(D) Y[1][1]</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>程式初始化一個 3x3 的二維陣列 <code>Y</code>，其中 <code>Y[i][j] = (i+1)*(j+1)</code>。</p>
                        <p>首先計算 <code>Y[1][2]</code> 的值：</p>
                        <p><code>Y[1][2] = (1+1) * (2+1) = 2 * 3 = 6</code>。</p>
                        <p>現在計算各選項的值：</p>
                        <ul>
                            <li><b>(A) Y[2][1]:</b>
                                <code>Y[2][1] = (2+1) * (1+1) = 3 * 2 = 6</code>。
                            </li>
                            <li><b>(B) Y[2][2]:</b>
                                <code>Y[2][2] = (2+1) * (2+1) = 3 * 3 = 9</code>。
                            </li>
                            <li><b>(C) Y[2][3]:</b> 這是陣列索引越界，因為 <code>j</code> 的最大索引是 2 (對於 <code>Y[i][3]</code>)。如果能執行，其值會是 <code>(2+1)*(3+1) = 3*4 = 12</code>，但這是不合法的存取。</li>
                            <li><b>(D) Y[1][1]:</b>
                                <code>Y[1][1] = (1+1) * (1+1) = 2 * 2 = 4</code>。
                            </li>
                        </ul>
                        <p>比較結果：</p>
                        <p><code>Y[1][2] = 6</code></p>
                        <p><code>Y[2][1] = 6</code></p>
                        <p>因此，<code>Y[2][1]</code> 的值與 <code>Y[1][2]</code> 相同。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q38">下一題</button></div>
                </div>

                <div id="q38" class="quiz-card">
                    <h3>38.  下列程式片段執行後，N[1][2]的值是多少？</h3>
                    <pre><code class="language-c">int M[]={10,20,30,40,50,60};
int N[2][3]; // N has 2 rows, 3 columns
int k=0;

for (int i=0;i&lt;3;i++){ // i iterates for columns of N
    for (int j=0;j&lt;2;j++){ // j iterates for rows of N
        N[j][i]=M[k];
        k++;
    }
}</code></pre>
                    <button class="run-example-btn" data-code-id="q38-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 30</div>
                        <div class="option" data-option="B">(B) 40</div>
                        <div class="option" data-option="C">(C) 50</div>
                        <div class="option" data-option="D">(D) 60</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>陣列 <code>M = {10,20,30,40,50,60}</code>。</p>
                        <p>陣列 <code>N</code> 是一個 2 列 (rows) 3 行 (columns) 的二維陣列。</p>
                        <p>巢狀迴圈的賦值方式是 <code>N[j][i] = M[k];</code>。外層迴圈控制 <code>i</code> (從 0 到 2)，內層迴圈控制 <code>j</code> (從 0 到 1)。這表示陣列 <code>N</code> 是逐行 (column-by-column) 填入的。</p>
                        <table>
                            <thead><tr><th>i (外層, N的行)</th><th>j (內層, N的列)</th><th>k</th><th>M[k]</th><th>賦值給</th><th>N 的狀態 (概念上)</th></tr></thead>
                            <tbody>
                                <tr><td>-</td><td>-</td><td>0 (初始)</td><td>-</td><td>-</td><td><code>N = {{?, ?, ?}, {?, ?, ?}}</code></td></tr>
                                <tr><td>0</td><td>0</td><td>0</td><td>M[0]=10</td><td>N[0][0]=10</td><td rowspan="2"><code>N = {{10, ?, ?}, {20, ?, ?}}</code></td></tr>
                                <tr><td>0</td><td>1</td><td>1</td><td>M[1]=20</td><td>N[1][0]=20</td></tr>
                                <tr><td>1</td><td>0</td><td>2</td><td>M[2]=30</td><td>N[0][1]=30</td><td rowspan="2"><code>N = {{10, 30, ?}, {20, 40, ?}}</code></td></tr>
                                <tr><td>1</td><td>1</td><td>3</td><td>M[3]=40</td><td>N[1][1]=40</td></tr>
                                <tr><td>2</td><td>0</td><td>4</td><td>M[4]=50</td><td>N[0][2]=50</td><td rowspan="2"><code>N = {{10, 30, 50}, {20, 40, 60}}</code></td></tr>
                                <tr><td>2</td><td>1</td><td>5</td><td>M[5]=60</td><td>N[1][2]=60</td></tr>
                            </tbody>
                        </table>
                        <p>執行完畢後，陣列 <code>N</code> 的內容為：</p>
                        <p><code>N[0][0]=10, N[0][1]=30, N[0][2]=50</code></p>
                        <p><code>N[1][0]=20, N[1][1]=40, N[1][2]=60</code></p>
                        <p>題目要求 <code>N[1][2]</code> 的值，即 60。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q39">下一題</button></div>
                </div>

                <div id="q39" class="quiz-card">
                    <h3>39.  下列程式片段執行後的輸出為何？</h3>
                    <pre><code class="language-c">int s1=0, s2=1;
int K[]={90,25,64,87,12,49};

for  (int  i=0;i&lt;6;i++){
    if (K[i]>70) s1=s1+1;
    if (K[i]&lt;60) s2=s2+1;
}
printf("%d", s1*s2);</code></pre>
                    <button class="run-example-btn" data-code-id="q39-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 8</div>
                        <div class="option" data-option="B">(B) 6</div>
                        <div class="option" data-option="C">(C) 9</div>
                        <div class="option" data-option="D">(D) 36</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>初始化：<code>s1=0</code>, <code>s2=1</code>, <code>K={90,25,64,87,12,49}</code>。</p>
                        <p>迴圈 <code>for (int i=0; i&lt;6; i++)</code> 遍歷陣列 <code>K</code>。</p>
                        <table>
                            <thead><tr><th>i</th><th>K[i]</th><th>K[i]>70?</th><th>s1 變化</th><th>K[i]&lt;60?</th><th>s2 變化</th><th>s1 (累計)</th><th>s2 (累計)</th></tr></thead>
                            <tbody>
                                <tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>0</td><td>1</td></tr>
                                <tr><td>0</td><td>90</td><td>90>70 (T)</td><td>s1=0+1=1</td><td>90&lt;60 (F)</td><td>-</td><td>1</td><td>1</td></tr>
                                <tr><td>1</td><td>25</td><td>25>70 (F)</td><td>-</td><td>25&lt;60 (T)</td><td>s2=1+1=2</td><td>1</td><td>2</td></tr>
                                <tr><td>2</td><td>64</td><td>64>70 (F)</td><td>-</td><td>64&lt;60 (F)</td><td>-</td><td>1</td><td>2</td></tr>
                                <tr><td>3</td><td>87</td><td>87>70 (T)</td><td>s1=1+1=2</td><td>87&lt;60 (F)</td><td>-</td><td>2</td><td>2</td></tr>
                                <tr><td>4</td><td>12</td><td>12>70 (F)</td><td>-</td><td>12&lt;60 (T)</td><td>s2=2+1=3</td><td>2</td><td>3</td></tr>
                                <tr><td>5</td><td>49</td><td>49>70 (F)</td><td>-</td><td>49&lt;60 (T)</td><td>s2=3+1=4</td><td>2</td><td>4</td></tr>
                            </tbody>
                        </table>
                        <p>迴圈結束後，<code>s1 = 2</code>，<code>s2 = 4</code>。</p>
                        <p><code>printf("%d", s1*s2);</code> => <code>printf("%d", 2*4);</code> => 印出 8。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q40">下一題</button></div>
                </div>

                <div id="q40" class="quiz-card">
                    <h3>40.  下列程式片段執行後，變數 sum 的值為何？</h3>
                    <pre><code class="language-c">int a, sum=0;
int F[]={1,-2,3,-4,5};

for (int i=0;i&lt;5;i++){
    a=F[i];
    if (a>0)
        a=0-a; // Negates positive numbers
    // else a=0+a; // This line is redundant as 'a' would remain unchanged if not positive
    sum=sum+a;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q40-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) -14</div>
                        <div class="option" data-option="B">(B) 14</div>
                        <div class="option" data-option="C">(C) -15</div>
                        <div class="option" data-option="D">(D) 15</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>初始化：<code>sum=0</code>, <code>F={1,-2,3,-4,5}</code>。</p>
                        <p>迴圈 <code>for (int i=0; i&lt;5; i++)</code> 遍歷陣列 <code>F</code>。</p>
                        <p>如果 <code>F[i]</code> (即 <code>a</code>) 是正數，則將其變為負數 (<code>a = 0 - a</code>)。如果 <code>a</code> 是負數或零，<code>else a=0+a;</code> 這行實際上不會改變 <code>a</code> 的值。</p>
                        <table>
                            <thead><tr><th>i</th><th>F[i]</th><th>a (初始)</th><th>條件(a>0)</th><th>a (變化後)</th><th>sum=sum+a</th><th>sum (累計)</th></tr></thead>
                            <tbody>
                                <tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>0</td></tr>
                                <tr><td>0</td><td>1</td><td>1</td><td>1>0 (T)</td><td>a = 0-1 = -1</td><td>sum = 0 + (-1)</td><td>-1</td></tr>
                                <tr><td>1</td><td>-2</td><td>-2</td><td>-2>0 (F)</td><td>a = -2 (不變)</td><td>sum = -1 + (-2)</td><td>-3</td></tr>
                                <tr><td>2</td><td>3</td><td>3</td><td>3>0 (T)</td><td>a = 0-3 = -3</td><td>sum = -3 + (-3)</td><td>-6</td></tr>
                                <tr><td>3</td><td>-4</td><td>-4</td><td>-4>0 (F)</td><td>a = -4 (不變)</td><td>sum = -6 + (-4)</td><td>-10</td></tr>
                                <tr><td>4</td><td>5</td><td>5</td><td>5>0 (T)</td><td>a = 0-5 = -5</td><td>sum = -10 + (-5)</td><td>-15</td></tr>
                            </tbody>
                        </table>
                        <p>最終 <code>sum</code> 的值為 -15。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q41">下一題</button></div>
                </div>

                <div id="q41" class="quiz-card">
                    <h3>41.  執行以下的程式片段後，元素 w[4]的值為何？</h3>
                    <pre><code class="language-c">int w[5] = {21, 65, 7, 19, 47};
int t;
for (int i=1; i&lt;5; i++){
    if (w[i]&lt;w[i-1]){
        t=w[i];
        w[i] = w[i-1];
        w[i-1] = t;
    }
}</code></pre>
                    <button class="run-example-btn" data-code-id="q41-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 7</div>
                        <div class="option" data-option="B">(B) 19</div>
                        <div class="option" data-option="C">(C) 47</div>
                        <div class="option" data-option="D">(D) 65</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤 (單趟氣泡排序)</h4>
                        <p>此程式片段對陣列 <code>w</code> 執行一次類似氣泡排序的遍歷。它比較相鄰的元素，如果後一個元素小於前一個元素，則交換它們。這會將較小的元素逐漸「冒泡」到陣列的前端。</p>
                        <p>初始陣列：<code>w = {21, 65, 7, 19, 47}</code></p>
                        <table>
                            <thead><tr><th>i</th><th>w[i]</th><th>w[i-1]</th><th>條件 (w[i]&lt;w[i-1])</th><th>動作 (交換)</th><th>陣列 w 狀態</th></tr></thead>
                            <tbody>
                                <tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>{21, 65, 7, 19, 47}</td></tr>
                                <tr><td>1</td><td>w[1]=65</td><td>w[0]=21</td><td>65&lt;21 (F)</td><td>不交換</td><td>{21, 65, 7, 19, 47}</td></tr>
                                <tr><td>2</td><td>w[2]=7</td><td>w[1]=65</td><td>7&lt;65 (T)</td><td>t=7, w[2]=65, w[1]=7</td><td>{21, 7, 65, 19, 47}</td></tr>
                                <tr><td>3</td><td>w[3]=19</td><td>w[2]=65</td><td>19&lt;65 (T)</td><td>t=19, w[3]=65, w[2]=19</td><td>{21, 7, 19, 65, 47}</td></tr>
                                <tr><td>4</td><td>w[4]=47</td><td>w[3]=65</td><td>47&lt;65 (T)</td><td>t=47, w[4]=65, w[3]=47</td><td>{21, 7, 19, 47, 65}</td></tr>
                            </tbody>
                        </table>
                        <p>迴圈結束後，陣列 <code>w</code> 的狀態為 <code>{21, 7, 19, 47, 65}</code>。</p>
                        <p>題目要求元素 <code>w[4]</code> 的值，即 65。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q42">下一題</button></div>
                </div>

                <div id="q42" class="quiz-card">
                    <h3>42.  執行以下的程式片段後，元素 w[4]的值為何？</h3>
                    <pre><code class="language-c">int w[5] = {21, 65, 7, 19, 47};
int t;
for (int i=1; i&lt;5; i++){
    if (w[i]&gt;w[i-1]){ // 注意比較符號是 >
        t=w[i];
        w[i] = w[i-1];
        w[i-1] = t;
    }
}</code></pre>
                    <button class="run-example-btn" data-code-id="q42-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 7</div>
                        <div class="option" data-option="B">(B) 19</div>
                        <div class="option" data-option="C">(C) 47</div>
                        <div class="option" data-option="D">(D) 65</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤 (單趟反向氣泡排序)</h4>
                        <p>此程式片段對陣列 <code>w</code> 執行一次遍歷。它比較相鄰的元素，如果後一個元素 <code>w[i]</code> **大於** 前一個元素 <code>w[i-1]</code>，則交換它們。這會將較大的元素逐漸「冒泡」到陣列的前端 (索引較小的位置)。</p>
                        <p>初始陣列：<code>w = {21, 65, 7, 19, 47}</code></p>
                        <table>
                            <thead><tr><th>i</th><th>w[i]</th><th>w[i-1]</th><th>條件 (w[i]&gt;w[i-1])</th><th>動作 (交換)</th><th>陣列 w 狀態</th></tr></thead>
                            <tbody>
                                <tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>{21, 65, 7, 19, 47}</td></tr>
                                <tr><td>1</td><td>w[1]=65</td><td>w[0]=21</td><td>65&gt;21 (T)</td><td>t=65, w[1]=21, w[0]=65</td><td>{65, 21, 7, 19, 47}</td></tr>
                                <tr><td>2</td><td>w[2]=7</td><td>w[1]=21</td><td>7&gt;21 (F)</td><td>不交換</td><td>{65, 21, 7, 19, 47}</td></tr>
                                <tr><td>3</td><td>w[3]=19</td><td>w[2]=7</td><td>19&gt;7 (T)</td><td>t=19, w[3]=7, w[2]=19</td><td>{65, 21, 19, 7, 47}</td></tr>
                                <tr><td>4</td><td>w[4]=47</td><td>w[3]=7</td><td>47&gt;7 (T)</td><td>t=47, w[4]=7, w[3]=47</td><td>{65, 21, 19, 47, 7}</td></tr>
                            </tbody>
                        </table>
                        <p>迴圈結束後，陣列 <code>w</code> 的狀態為 <code>{65, 21, 19, 47, 7}</code>。</p>
                        <p>題目要求元素 <code>w[4]</code> 的值，即 7。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q43">下一題</button></div>
                </div>

                <div id="q43" class="quiz-card">
                    <h3>43.  執行以下的程式片段後，元素 w[0]的值為何？</h3>
                    <pre><code class="language-c">int w[5] = {21, 65, 7, 19, 47};
int t;
for (int i=1; i&lt;5; i++){
    if (w[0]&gt;w[i]){ // 比較 w[0] 與 w[i]
        t=w[0];    // 標準交換邏輯
        w[0] = w[i];
        w[i] = t;
    }
}</code></pre>
                    <button class="run-example-btn" data-code-id="q43-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 7</div>
                        <div class="option" data-option="B">(B) 19</div>
                        <div class="option" data-option="C">(C) 47</div>
                        <div class="option" data-option="D">(D) 65</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤 (尋找最小值並置於首位)</h4>
                        <p>此程式片段遍歷陣列 <code>w</code> (從第二個元素開始)，並將 <code>w[0]</code> 與每個後續元素 <code>w[i]</code> 比較。如果 <code>w[0]</code> 大於 <code>w[i]</code>，則交換它們。這個過程的結果是將整個陣列中的最小值放到 <code>w[0]</code> 的位置。</p>
                        <p>初始陣列：<code>w = {21, 65, 7, 19, 47}</code></p>
                        <table>
                            <thead><tr><th>i</th><th>w[0] (比較前)</th><th>w[i]</th><th>條件 (w[0]&gt;w[i])</th><th>動作 (交換)</th><th>陣列 w 狀態 (w[0]的變化)</th></tr></thead>
                            <tbody>
                                <tr><td>-</td><td>21</td><td>-</td><td>-</td><td>-</td><td>{<b>21</b>, 65, 7, 19, 47}</td></tr>
                                <tr><td>1</td><td>21</td><td>w[1]=65</td><td>21&gt;65 (F)</td><td>不交換</td><td>{<b>21</b>, 65, 7, 19, 47}</td></tr>
                                <tr><td>2</td><td>21</td><td>w[2]=7</td><td>21&gt;7 (T)</td><td>t=21,w[0]=7,w[2]=21</td><td>{<b>7</b>, 65, 21, 19, 47}</td></tr>
                                <tr><td>3</td><td>7</td><td>w[3]=19</td><td>7&gt;19 (F)</td><td>不交換</td><td>{<b>7</b>, 65, 21, 19, 47}</td></tr>
                                <tr><td>4</td><td>7</td><td>w[4]=47</td><td>7&gt;47 (F)</td><td>不交換</td><td>{<b>7</b>, 65, 21, 19, 47}</td></tr>
                            </tbody>
                        </table>
                        <p>迴圈結束後，<code>w[0]</code> 的值為 7 (陣列中的最小值)。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q44">下一題</button></div>
                </div>

                <div id="q44" class="quiz-card">
                    <h3>44.  執行以下的程式片段後，w[0]的值為何？</h3>
                    <pre><code class="language-c">int w[5] = {21, 65, 7, 19, 47};
int t;
for (int i=1; i&lt;5; i++){
    if (w[0]&lt;w[i]){ // 比較 w[0] 與 w[i]
        t=w[0];    // 標準交換邏輯
        w[0] = w[i];
        w[i] = t;
    }
}</code></pre>
                    <button class="run-example-btn" data-code-id="q44-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 7</div>
                        <div class="option" data-option="B">(B) 19</div>
                        <div class="option" data-option="C">(C) 47</div>
                        <div class="option" data-option="D">(D) 65</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤 (尋找最大值並置於首位)</h4>
                        <p>此程式片段遍歷陣列 <code>w</code> (從第二個元素開始)，並將 <code>w[0]</code> 與每個後續元素 <code>w[i]</code> 比較。如果 <code>w[0]</code> **小於** <code>w[i]</code>，則交換它們。這個過程的結果是將整個陣列中的最大值放到 <code>w[0]</code> 的位置。</p>
                        <p>初始陣列：<code>w = {21, 65, 7, 19, 47}</code></p>
                        <table>
                            <thead><tr><th>i</th><th>w[0] (比較前)</th><th>w[i]</th><th>條件 (w[0]&lt;w[i])</th><th>動作 (交換)</th><th>陣列 w 狀態 (w[0]的變化)</th></tr></thead>
                            <tbody>
                                <tr><td>-</td><td>21</td><td>-</td><td>-</td><td>-</td><td>{<b>21</b>, 65, 7, 19, 47}</td></tr>
                                <tr><td>1</td><td>21</td><td>w[1]=65</td><td>21&lt;65 (T)</td><td>t=21,w[0]=65,w[1]=21</td><td>{<b>65</b>, 21, 7, 19, 47}</td></tr>
                                <tr><td>2</td><td>65</td><td>w[2]=7</td><td>65&lt;7 (F)</td><td>不交換</td><td>{<b>65</b>, 21, 7, 19, 47}</td></tr>
                                <tr><td>3</td><td>65</td><td>w[3]=19</td><td>65&lt;19 (F)</td><td>不交換</td><td>{<b>65</b>, 21, 7, 19, 47}</td></tr>
                                <tr><td>4</td><td>65</td><td>w[4]=47</td><td>65&lt;47 (F)</td><td>不交換</td><td>{<b>65</b>, 21, 7, 19, 47}</td></tr>
                            </tbody>
                        </table>
                        <p>迴圈結束後，<code>w[0]</code> 的值為 65 (陣列中的最大值)。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q21">回到本頁第一題</button></div>
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
  printf("Hello from bb4-2.php!\\nSelect a question example or write your own code.\\n");
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
            const codeSamples = { // Samples for Q21-Q44
                'q21-code': `#include <stdio.h>\n\nint main() {\n  int arr[4]={0,1,2,3};\n  printf("*arr = %d\\n", *arr);\n  return 0;\n}`,
                'q36-code': `#include <stdio.h>\n\nint main() {\n    int item=5;\n    int T[]={2,4,6,8,10,12};\n    int S[item]; \n    for (int m=0;m<item;m++){ S[m]=T[m];}\n    printf("%d\\n", T[T[0]+1]+2);\n    return 0;\n}`,
                'q37-code': `#include <stdio.h>\n\nint main() {\n    int Y[3][3];\n    for (int i=0;i<3;i++){ for (int j=0;j<3;j++){ Y[i][j]=(i+1)*(j+1);}}\n    printf("Y[1][2] = %d\\n", Y[1][2]);\n    printf("Y[2][1] = %d\\n", Y[2][1]);\n    return 0;\n}`,
                'q38-code': `#include <stdio.h>\n\nint main() {\n    int M[]={10,20,30,40,50,60};\n    int N[2][3];\n    int k=0;\n    for (int i=0;i<3;i++){ for (int j=0;j<2;j++){ N[j][i]=M[k]; k++;}}\n    printf("N[1][2] = %d\\n", N[1][2]);\n    return 0;\n}`,
                'q39-code': `#include <stdio.h>\n\nint main() {\n    int s1=0, s2=1;\n    int K[]={90,25,64,87,12,49};\n    for  (int  i=0;i<6;i++){ if (K[i]>70) s1=s1+1; if (K[i]<60) s2=s2+1;}\n    printf("%d\\n", s1*s2);\n    return 0;\n}`,
                'q40-code': `#include <stdio.h>\n\nint main() {\n    int a, sum=0;\n    int F[]={1,-2,3,-4,5};\n    for (int i=0;i<5;i++){ a=F[i]; if (a>0) a=0-a; sum=sum+a;}\n    printf("%d\\n", sum);\n    return 0;\n}`,
                'q41-code': `#include <stdio.h>\n\nint main() {\n    int w[5] = {21, 65, 7, 19, 47};\n    int t;\n    for (int i=1; i<5; i++){ if (w[i]<w[i-1]){ t=w[i]; w[i] = w[i-1]; w[i-1] = t;}}\n    printf("w[4] = %d\\n", w[4]);\n    return 0;\n}`,
                'q42-code': `#include <stdio.h>\n\nint main() {\n    int w[5] = {21, 65, 7, 19, 47};\n    int t;\n    for (int i=1; i<5; i++){ if (w[i]>w[i-1]){ t=w[i]; w[i] = w[i-1]; w[i-1] = t;}}\n    printf("w[4] = %d\\n", w[4]);\n    return 0;\n}`,
                'q43-code': `#include <stdio.h>\n\nint main() {\n    int w[5] = {21, 65, 7, 19, 47};\n    int t;\n    for (int i=1; i<5; i++){ if (w[0]>w[i]){ t=w[0]; w[0]=w[i]; w[i]=t;}}\n    printf("w[0] = %d\\n", w[0]);\n    return 0;\n}`,
                'q44-code': `#include <stdio.h>\n\nint main() {\n    int w[5] = {21, 65, 7, 19, 47};\n    int t;\n    for (int i=1; i<5; i++){ if (w[0]<w[i]){ t=w[0]; w[0]=w[i]; w[i]=t;}}\n    printf("w[0] = %d\\n", w[0]);\n    return 0;\n}`
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

            if (codeSamples['q21-code']) { // Check for a relevant question from this set
                 codeEditor.value = codeSamples['q21-code'];
            } else if (Object.keys(codeSamples).length > 0) {
                 codeEditor.value = codeSamples[Object.keys(codeSamples)[0]];
            } else {
                 codeEditor.value = "// Welcome! No runnable examples in this section. Write your own C/C++ code here.";
            }
        });
    </script>
</body>
</html>
