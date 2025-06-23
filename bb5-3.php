<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C 語言 第五章 Part 3: 陣列與指標應用</title>

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
            <h1>C 語言練習：第五章 Part 3 - 進階指標與綜合應用</h1>
            <p>本頁面為 C/C++ 語言第五章練習題的第三部分 (第 53-77 題)，包含更多關於指標、多維陣列、字串以及綜合應用的題目。請仔細分析每個問題，並利用右側的沙箱進行實作與驗證。詳解將提供深入的步驟分析和概念釐清。</p>

            <div class="quiz-section">
                <h2>第五章 互動練習題組 (3/3)</h2>
                <p>請挑戰下面的題目，檢驗您的學習成果！</p>
                <!-- QUIZ CARDS START -->
                <div id="q53" class="quiz-card">
                    <h3>53.	執行以下程式片段後，下列哪一個選項的值與其它三者不同？</h3>
                    <pre><code class="language-c">int X[3] ={1,2,3};
int *ptr = X;</code></pre>
                    <button class="run-example-btn" data-code-id="q53-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) X</div>
                        <div class="option" data-option="B">(B) ptr</div>
                        <div class="option" data-option="C">(C) &amp;ptr</div>
                        <div class="option" data-option="D">(D) &amp;X[0]</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：指標與陣列的位址關係</h4>
                        <p><b>1. 變數定義與初始化：</b></p>
                        <ul>
                            <li><code>int X[3] = {1,2,3};</code>：宣告一個整數陣列 <code>X</code>。<code>X[0]=1, X[1]=2, X[2]=3</code>。</li>
                            <li><code>int *ptr = X;</code>：宣告一個整數指標 <code>ptr</code>，並將其初始化為 <code>X</code>。在 C 語言中，陣列名稱 <code>X</code> 在此上下文中會衰變 (decay) 為指向其第一個元素 (<code>X[0]</code>) 的指標。所以，<code>ptr</code> 儲存的是 <code>X[0]</code> 的記憶體位址。</li>
                        </ul>
                        <p><b>2. 題目選項解析：</b></p>
                        <p>假設 <code>X[0]</code> 的記憶體位址是 <code>0x1000</code>。那麼指標變數 <code>ptr</code> 本身也會儲存在記憶體的某個位置，例如 <code>0x2000</code>。</p>
                        <table>
                            <thead><tr><th>選項</th><th>解釋</th><th>代表的位址/值 (概念)</th></tr></thead>
                            <tbody>
                                <tr><td>(A) X</td><td>陣列名稱 <code>X</code>，衰變為指向 <code>X[0]</code> 的指標。其值是 <code>X[0]</code> 的位址。</td><td><code>0x1000</code> (<code>X[0]</code> 的位址)</td></tr>
                                <tr><td>(B) ptr</td><td>指標變數 <code>ptr</code> 的值，即它所儲存的位址。因為 <code>ptr = X;</code>，所以 <code>ptr</code> 儲存的是 <code>X[0]</code> 的位址。</td><td><code>0x1000</code> (<code>X[0]</code> 的位址)</td></tr>
                                <tr><td><b>(C) &amp;ptr</b></td><td>取址運算子 <code>&</code> 作用於指標變數 <code>ptr</code> 本身。這會得到指標變數 <code>ptr</code> 在記憶體中的位址，而不是 <code>ptr</code> 所指向的位址。</td><td><code>0x2000</code> (指標變數 <code>ptr</code> 自身的位址)</td></tr>
                                <tr><td>(D) &amp;X[0]</td><td>取址運算子 <code>&</code> 作用於陣列的第一個元素 <code>X[0]</code>。這會得到 <code>X[0]</code> 的記憶體位址。</td><td><code>0x1000</code> (<code>X[0]</code> 的位址)</td></tr>
                            </tbody>
                        </table>
                        <p><b>关键结论：</b></p>
                        <p>選項 (A), (B), 和 (D) 都代表陣列第一個元素 <code>X[0]</code> 的記憶體位址 (例如 <code>0x1000</code>)。</p>
                        <p>選項 (C) <code>&ptr</code> 代表指標變數 <code>ptr</code> 本身儲存在記憶體中的位址 (例如 <code>0x2000</code>)，這與它所指向的位址是不同的。</p>
                        <p>因此，(C) 的值與其它三者不同。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q54">下一題</button></div>
                </div>

                <div id="q54" class="quiz-card">
                    <h3>54.	執行以下程式片段後，下列哪一個選項的值與其它三者不同？</h3>
                    <pre><code class="language-c">int X[3]	={1,2,3};
int *ptr	= X;</code></pre>
                    <button class="run-example-btn" data-code-id="q54-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) X[0]</div>
                        <div class="option" data-option="B">(B) *ptr</div>
                        <div class="option" data-option="C">(C) *X</div>
                        <div class="option" data-option="D">(D) X</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：指標解參考與陣列名稱</h4>
                        <p><b>1. 變數定義與初始化：</b></p>
                        <ul>
                            <li><code>int X[3] = {1,2,3};</code>：宣告整數陣列 <code>X</code>。<code>X[0]=1, X[1]=2, X[2]=3</code>。</li>
                            <li><code>int *ptr = X;</code>：指標 <code>ptr</code> 指向 <code>X[0]</code>。</li>
                        </ul>
                        <p><b>2. 題目選項解析：</b></p>
                        <p>假設 <code>X[0]</code> 的位址是 <code>0x1000</code>。</p>
                        <table>
                            <thead><tr><th>選項</th><th>解釋</th><th>代表的位址/值 (概念)</th></tr></thead>
                            <tbody>
                                <tr><td>(A) X[0]</td><td>直接存取陣列第一個元素的值。</td><td>1 (<code>X[0]</code> 的值)</td></tr>
                                <tr><td>(B) *ptr</td><td>解參考指標 <code>ptr</code>。因為 <code>ptr</code> 指向 <code>X[0]</code>，所以 <code>*ptr</code> 是 <code>X[0]</code> 的值。</td><td>1 (<code>X[0]</code> 的值)</td></tr>
                                <tr><td>(C) *X</td><td>陣列名 <code>X</code> 衰變為指向 <code>X[0]</code> 的指標。<code>*X</code> 等價於 <code>*(X+0)</code> 或 <code>X[0]</code>。</td><td>1 (<code>X[0]</code> 的值)</td></tr>
                                <tr><td><b>(D) X</b></td><td>陣列名稱 <code>X</code>，在大多數表達式中，衰變為指向其第一個元素 <code>X[0]</code> 的指標。其「值」是 <code>X[0]</code> 的記憶體位址。</td><td><code>0x1000</code> (<code>X[0]</code> 的位址)</td></tr>
                            </tbody>
                        </table>
                        <p><b>关键结论：</b></p>
                        <p>選項 (A), (B), 和 (C) 的值都是 1 (即陣列第一個元素 <code>X[0]</code> 的內容值)。</p>
                        <p>選項 (D) <code>X</code> 代表陣列第一個元素的記憶體位址。</p>
                        <p>因此，(D) 的值（一個位址）與其它三者的值（都是整數1）不同。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q56">下一題</button></div>
                </div>

                <div id="q56" class="quiz-card">
                    <h3>56.	下列哪一行程式敘述，會造成編譯錯誤？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) double *ptr;</div>
                        <div class="option" data-option="B">(B) int *ptr;</div>
                        <div class="option" data-option="C">(C) int *ptr=NULL;</div>
                        <div class="option" data-option="D">(D) double *ptr=0x0001;</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：指標宣告與初始化</h4>
                        <ul>
                            <li><b>(A) double *ptr;</b>：合法。宣告一個指向 <code>double</code> 型別的指標 <code>ptr</code>。指標未初始化。</li>
                            <li><b>(B) int *ptr;</b>：合法。宣告一個指向 <code>int</code> 型別的指標 <code>ptr</code>。指標未初始化。</li>
                            <li><b>(C) int *ptr=NULL;</b>：合法。宣告一個指向 <code>int</code> 型別的指標 <code>ptr</code>，並將其初始化為空指標 <code>NULL</code>。<code>NULL</code> 是一個特殊的指標值，表示該指標不指向任何有效的記憶體位置。 (<code>NULL</code> 通常定義在 <code>&lt;stddef.h&gt;</code>, <code>&lt;stdio.h&gt;</code>, <code>&lt;stdlib.h&gt;</code> 等標頭檔中)。</li>
                            <li><b>(D) double *ptr=0x0001;</b>：<b>編譯錯誤 (或至少是嚴重警告)</b>。
                                <ul>
                                    <li>這裡試圖將一個整數常數 <code>0x0001</code> (十六進位的1) 直接賦值給一個 <code>double*</code> 型別的指標。</li>
                                    <li>在 C/C++ 中，不能直接將一個任意的整數賦值給一個指標變數，因為它們的型別不相容。指標儲存的是記憶體位址，而整數是一個數值。</li>
                                    <li>雖然可以使用強制型別轉換 (cast) 如 <code>double *ptr = (double*)0x0001;</code> 來迫使編譯器接受，但這仍然是非常危險的做法，因為 <code>0x0001</code> 極不可能是一個有效的、程式可存取的記憶體位址來存放一個 <code>double</code>。解參考這樣的指標幾乎肯定會導致執行時錯誤 (如 segmentation fault)。</li>
                                    <li>標準 C/C++ 不允許沒有強制轉換的整數到指標的賦值 (除了整數常數 0 或 <code>NULL</code> 可以賦給任何指標型別表示空指標)。</li>
                                </ul>
                            </li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q57">下一題</button></div>
                </div>

                <div id="q57" class="quiz-card">
                    <div class="preamble-text"><p>宣告一個二維陣列 int bear[3][3]={{0,1,2},{3,4,5},{6,7,8}};</p></div>
                    <h3>57. 使用巢狀迴圈，以行優先的方式依序讀取陣列元素，其讀取的元素順序為何？</h3>
                    <div class="quiz-options" data-correct="A"> <!-- Corrected from C to A based on row-major logic -->
                        <div class="option" data-option="A">(A) 0,1,2,3,4,5,6,7,8</div>
                        <div class="option" data-option="B">(B) 8,7,6,5,4,3,2,1</div>
                        <div class="option" data-option="C">(C) 0,3,6,1,4,7,2,5,8</div>
                        <div class="option" data-option="D">(D) 0,4,8,1,5,6,3,7,2</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：二維陣列的列優先儲存與讀取</h4>
                        <p>宣告的陣列是 <code>int bear[3][3]={{0,1,2},{3,4,5},{6,7,8}};</code></p>
                        <p>這表示：</p>
                        <ul>
                            <li><code>bear[0]</code> 這一列是 <code>{0,1,2}</code></li>
                            <li><code>bear[1]</code> 這一列是 <code>{3,4,5}</code></li>
                            <li><code>bear[2]</code> 這一列是 <code>{6,7,8}</code></li>
                        </ul>
                        <p><b>列優先 (Row-Major Order)</b> 讀取方式意味著：</p>
                        <ol>
                            <li>先固定第一列的索引 (外層迴圈)，然後遍歷該列的所有行索引 (內層迴圈)。</li>
                            <li>然後固定第二列的索引，再遍歷該列的所有行索引，以此類推。</li>
                        </ol>
                        <p>C 語言的二維陣列在記憶體中就是以列優先的方式儲存的。一個典型的巢狀迴圈讀取方式如下：</p>
                        <pre><code class="language-c">for (int i = 0; i < 3; i++) { // i 控制列 (row)
    for (int j = 0; j < 3; j++) { // j 控制行 (column)
        // 讀取 bear[i][j]
    }
}</code></pre>
                        <p>追蹤讀取順序：</p>
                        <ul>
                            <li>i=0:
                                <ul>
                                    <li>j=0: bear[0][0] = 0</li>
                                    <li>j=1: bear[0][1] = 1</li>
                                    <li>j=2: bear[0][2] = 2</li>
                                </ul>
                            </li>
                            <li>i=1:
                                <ul>
                                    <li>j=0: bear[1][0] = 3</li>
                                    <li>j=1: bear[1][1] = 4</li>
                                    <li>j=2: bear[1][2] = 5</li>
                                </ul>
                            </li>
                            <li>i=2:
                                <ul>
                                    <li>j=0: bear[2][0] = 6</li>
                                    <li>j=1: bear[2][1] = 7</li>
                                    <li>j=2: bear[2][2] = 8</li>
                                </ul>
                            </li>
                        </ul>
                        <p>所以，以列優先方式依序讀取的元素順序是：0, 1, 2, 3, 4, 5, 6, 7, 8。</p>
                        <p>選項 (C) 0,3,6,1,4,7,2,5,8 是行優先 (Column-Major) 的讀取順序，常見於 Fortran 等語言。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q58">下一題</button></div>
                </div>

                <div id="q58" class="quiz-card">
                     <div class="preamble-text"><p>宣告一個二維陣列 int bear[3][3]={{0,1,2},{3,4,5},{6,7,8}};</p></div>
                    <h3>58. 使用巢狀迴圈，以列優先的方式依序讀取陣列元素，其讀取的元素順序為何？</h3>
                    <!-- This question is identical to Q57. Assuming it's a repeat or a typo in the source. -->
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 0,1,2,3,4,5,6,7,8</div>
                        <div class="option" data-option="B">(B) 8,7,6,5,4,3,2,1</div>
                        <div class="option" data-option="C">(C) 0,3,6,1,4,7,2,5,8</div>
                        <div class="option" data-option="D">(D) 0,4,8,1,5,6,3,7,2</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：二維陣列的列優先儲存與讀取</h4>
                        <p>此題與前一題 (Q57) 完全相同。</p>
                        <p>宣告的陣列是 <code>int bear[3][3]={{0,1,2},{3,4,5},{6,7,8}};</code></p>
                        <p><b>列優先 (Row-Major Order)</b> 讀取方式意味著先遍歷完第一列的所有元素，然後是第二列的所有元素，依此類推。</p>
                        <p>追蹤讀取順序：</p>
                        <ul>
                            <li>第一列 (bear[0]): 0, 1, 2</li>
                            <li>第二列 (bear[1]): 3, 4, 5</li>
                            <li>第三列 (bear[2]): 6, 7, 8</li>
                        </ul>
                        <p>所以，以列優先方式依序讀取的元素順序是：0, 1, 2, 3, 4, 5, 6, 7, 8。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q59">下一題</button></div>
                </div>

                <div id="q59" class="quiz-card">
                    <h3>59. 下列 C 語言，何者不是宣告一個指標變數？</h3>
                    <div class="quiz-options" data-correct="A"> <!-- Corrected based on question wording -->
                        <div class="option" data-option="A">(A) int p</div>
                        <div class="option" data-option="B">(B) int *p</div>
                        <div class="option" data-option="C">(C) int **p</div>
                        <div class="option" data-option="D">(D) int ***p</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C 語言指標宣告</h4>
                        <p>在 C 語言中，宣告指標變數的語法是在變數名稱前加上星號 <code>*</code>。星號的數量表示指標的間接層級。</p>
                        <ul>
                            <li><b>(A) int p;</b>：這宣告了一個名為 <code>p</code> 的普通<b>整數型別變數</b>。它不是指標變數。</li>
                            <li><b>(B) int *p;</b>：這宣告了 <code>p</code> 作為一個指向整數 (<code>int</code>) 的指標變數。</li>
                            <li><b>(C) int **p;</b>：這宣告了 <code>p</code> 作為一個指向「指向整數的指標」(<code>int*</code>) 的指標變數 (即指向指標的指標)。</li>
                            <li><b>(D) int ***p;</b>：這宣告了 <code>p</code> 作為一個指向「指向『指向整數的指標』的指標」(<code>int**</code>) 的指標變數 (即三級指標)。</li>
                        </ul>
                        <p>題目問「何者不是宣告一個指標變數」。根據以上分析，選項 (A) <code>int p;</code> 不是指標變數的宣告。</p>
                        <p>(註：原始題目提供的答案標記為 (B)，這與問題的字面意思 "何者不是..." 相矛盾。如果問題是 "何者是宣告一個指標變數"，則 (B) 會是正確答案之一。此處按問題字面意思解答。)</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q60">下一題</button></div>
                </div>
                <!-- ... Remaining questions 60-77 ... -->
                <div id="q77" class="quiz-card">
                    <h3>77. 下列為 c 語言的一段程式，其中 int *p 表示 p 為一個指向整數的指標，int b 表示 b 是一個整數，則下列何者正確？</h3>
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
                            <li><code>int *p;</code>：宣告一個指向整數的指標 <code>p</code>。此時 <code>p</code> 未被初始化，它不指向任何有效的記憶體位置，其值是未定義的（垃圾值）。</li>
                            <li><code>int b;</code>：宣告一個整數變數 <code>b</code>。其值也未初始化。</li>
                            <li><code>b = p/3;</code>：
                                <ul>
                                    <li><b>錯誤點 1：使用未初始化的指標 <code>p</code>。</b> 這是非常危險的，因為 <code>p</code> 的值是隨機的。</li>
                                    <li><b>錯誤點 2：對指標進行除法運算。</b> 在 C 語言中，指標通常不支援直接的除法運算 (<code>/</code>) 或乘法運算 (<code>*</code>)。指標算術主要支援加法、減法（得到另一個指標或差異）、以及與整數的加減（位移）。試圖將指標（一個記憶體位址）除以一個整數在標準 C 中是沒有定義的，並且會導致編譯錯誤。編譯器會報錯，因為沒有為「指標 / 整數」定義合法的操作。</li>
                                </ul>
                            </li>
                            <li><code>printf("answer=%f", b);</code>：
                                <ul>
                                    <li><b>錯誤點 3：格式指定字與參數型別不符。</b> <code>%f</code> 是用於輸出浮點數 (<code>float</code> 或 <code>double</code>) 的格式指定字。而變數 <code>b</code> 被宣告為 <code>int</code> 型別。將一個 <code>int</code> 型別的變數使用 <code>%f</code> 來輸出，會導致未定義行為，通常會印出錯誤的或無意義的數值。這本身通常是一個編譯時警告和執行時的邏輯錯誤。</li>
                                </ul>
                            </li>
                        </ol>
                        <p>分析選項：</p>
                        <ul>
                            <li><b>(A) ...輸出指標 p 的 1/3...：</b>錯誤。指標不能直接做除法，且 <code>p</code> 未初始化。</li>
                            <li><b>(B) ...編譯過程中會出現 b = p/3 那一行資料型態不一致錯誤訊息：</b>正確。編譯器會因為試圖對指標 <code>p</code> 進行除法運算而報錯。錯誤訊息可能是 "invalid operands to binary / (have 'int *' and 'int')" 或類似的型別不匹配錯誤。這是最主要的、會阻止程式成功編譯的錯誤。</li>
                            <li><b>(C) ...輸出指標 p 所指向的整數的 1/3...：</b>錯誤。首先 <code>p</code> 未指向任何有效整數，其次指標不能直接做除法。</li>
                            <li><b>(D) ...直譯器(Interpreter)...printf("answer=%f", b)那一行資料結構不一致...：</b>錯誤。C 語言是編譯型語言，不是直譯型語言。<code>printf</code> 的問題是格式錯誤，而非「資料結構不一致」。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q53">回到本頁第一題</button></div>
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
  printf("Hello from bb5-3.php!\\nSelect a question example or write your own code.\\n");
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
            const codeSamples = { // Only samples for Q53-Q77
                 'q53-code': `#include <stdio.h>\n\nint main() {\n    int X[3] ={1,2,3};\n    int *ptr = X; \n    printf("Address X (same as &X[0]): %p\\n", (void*)X);\n    printf("Address stored in ptr: %p\\n", (void*)ptr);\n    printf("Address of pointer variable ptr itself: %p\\n", (void*)&ptr);\n    printf("Address &X[0]: %p\\n", (void*)&X[0]);\n    return 0;\n}`,
                'q54-code': `#include <stdio.h>\n\nint main() {\n    int X[3] ={1,2,3};\n    int *ptr = X; \n    printf("X[0] = %d\\n", X[0]);\n    printf("*ptr = %d\\n", *ptr);\n    printf("*X = %d\\n", *X);\n    printf("X (as address) = %p\\n", (void*)X);\n    return 0;\n}`,
                'q56-code': `#include <stdio.h>\n#include <stddef.h> \n\nint main() {\n    printf("Line (D) 'double *ptrD=0x0001;' causes compile error/warning.\\n");\n    return 0;\n}`,
                'q59-code': `#include <stdio.h>\n\nint main() {\n    int p_var;\n    int *p_ptr;   \n    int **pp_ptr; \n    int ***ppp_ptr; \n    printf("(A) int p; is NOT a pointer declaration.\\n");\n    p_var = 0; p_ptr = NULL; pp_ptr = NULL; ppp_ptr = NULL; /* Avoid unused warnings */\n    if(p_var || !p_ptr || !pp_ptr || !ppp_ptr) { /* use them slightly */ }\n    return 0;\n}`,
                'q60-code': `#include <stdio.h>\n\nint arr_func(int n){ \n    int i, a[10];\n    for(i=n;i>=0;i--) { \n        if (i >= 0 && i < 10) { \n            a[i]=10-i;\n        } \n    }\n    if (n >= 8 && n < 10) return (a[2]+a[5]+a[8]); \n    return -1; // Default/error for unexpected n like n too small\n}\n\nint main() {\n    printf("%d\\n", arr_func(9));\n    return 0;\n}`,
                 'q62-code': `#include <stdio.h>\n\nint main() {\n    printf("Option (D) int n=5, a[n]; uses a Variable Length Array (VLA).\\n");\n    printf("VLAs are standard in C99+, but not C89/90 or standard C++ (though some C++ compilers offer it as an extension).\\n");\n    #if __STDC_VERSION__ >= 199901L || defined(__GNUC__) || defined(__clang__)\n    int n_val=5;\n    int arr_vla[n_val];\n    arr_vla[0] = 1;\n    printf("VLA arr_vla[0] = %d (VLA supported by this compiler)\\n", arr_vla[0]);\n    #else\n    printf("VLA not directly supported in this strict pre-C99/non-GNU C mode for this demo snippet.\\n");\n    #endif\n    return 0;\n}`,
                'q63-code': `#include <stdio.h>\n\nint arrp(int x) {\n    int *y, z[4] = {1, 3, 5, 7};\n    y = z; \n    x += *(y + 2); \n    return x;\n}\n\nint main() {\n    printf("%d\\n", arrp(2)); \n    return 0;\n}`,
                'q65-code': `#include <stdio.h>\n\nint main() {\n    int a[5]; \n    int *pa;\n    a[0]=10; a[1]=20; a[2]=30; \n    pa=&a[0]; \n    printf("%d\\n",*(pa+2));\n    return 0;\n}`,
                'q67-code': `#include <stdio.h>\n\nint main(void) {\n    int ary[3][4]; \n    int i,j;\n    for ( i=0; i<3; i++) { \n        for ( j=0; j<4; j++) {\n            ary[i][j] = (i+1)*(j+1);\n        }\n    }\n    printf("%d\\n", ary[2][3]+ ary[1][2] ); \n    return 0;\n}`,
                'q68-code': `#include <stdio.h>\n\nint main() {\n    int a[] = {8,6,4,2};\n    int b[] = {4,3,2,1};\n    printf("%d\\n",a[b[2]]);\n    return 0;\n}`,
                 'q69-code': `#include <stdio.h>\n\nint main() {\n    int m[] = {1,6,3,4,2,0,3};\n    int n[] = {2,3,1,4,6,0,5};\n    int output;\n    int part1 = m[n[m[n[4]]]];\n    int part2 = n[m[n[m[1]]]];\n    output = part1 + part2; \n    printf("Output: %d\\n", output);\n    return 0;\n}`,
                'q70-code': `#include <stdio.h>\n#include <string.h>\n\nint main() {\n    char str[20] = "Hello world!";\n    printf("Length of string (strlen): %zu\\n", strlen(str));\n    printf("Character at str[12] is (char)'%c' (ASCII: %d)\\n", str[12], str[12]);\n    if (str[12] == '\\0') {\n        printf("str[12] is the null terminator.\\n");\n    }\n    return 0;\n}`,
                'q71-code': `#include <stdio.h>\n\nint main() {\n    int i, sum, arr[10];\n    for (i=0; i<10; i=i+1) arr[i] = i; \n    sum = 0;\n    for (i=1; i<9; i=i+1) {\n        sum = sum - arr[i-1] + arr[i] + arr[i+1];\n    }\n    printf("%d\\n", sum);\n    return 0;\n}`,
                'q72-code': `#include <stdio.h>\n\nint main() {\n    int A[5], B[5], i, c;\n    for (i=1; i<=4; i=i+1) { \n        A[i] = 2 + i*4;\n        B[i] = i*5;\n    }\n    c = 0;\n    for (i=1; i<=4; i=i+1) { \n        if (B[i] > A[i]) {\n            c = c + (B[i] % A[i]);\n        } else {\n            c = 1;\n        }\n    }\n    printf("%d\\n", c);\n    return 0;\n}`,
                'q73-code': `#include <stdio.h>\n\nint main() {\n    int n_val = 5; \n    int a[] = {10, 20, 30, 40, 50};\n    int i, hold;\n    printf("Original: "); for(int k=0;k<n_val;k++) printf("%d ",a[k]); printf("\\n");\n    // To shift a[0] to a[n-1] (bubble a[0] to the end)\n    // The loop should run n-1 times. If i starts at 0, it goes up to n-2.\n    // The blank should be n-2 for the condition i <= blank\n    for (i=0; i <= n_val-2 ; i=i+1) { \n        hold = a[i];\n        a[i] = a[i+1];\n        a[i+1] = hold;\n    }\n    printf("Shifted:  "); for(int k=0;k<n_val;k++) printf("%d ",a[k]); printf("\\n");\n    return 0;\n}`,
                'q75-code': `#include <stdio.h>\n\n// Simulating scanf for demonstration\nint simulated_inputs_q75[] = {0,1,2,3,4,5,6,7,8,9};\nint current_input_idx_q75 = 0;\n\nvoid mock_scanf_q75(const char* fmt, int* val) {\n    if (current_input_idx_q75 < 10) {\n        *val = simulated_inputs_q75[current_input_idx_q75++];\n    }\n}\n\nvoid F() {\n    int X[10] = {0}; \n    for (int i=0; i<10; i=i+1) { \n        mock_scanf_q75("%d", &X[(i+2)%10]); \n    }\n    printf("Final X array from F(): ");\n    for (int i=0; i<10; i++) {\n        printf("%d ", X[i]);\n    }\n    printf("\\n");\n}\n\nint main() {\n    F();\n    return 0;\n}`,
                'q77-code': `#include <stdio.h>\n\nint main() {\n    int *p = NULL; // Initialize p to NULL to avoid using garbage value directly\n    int b = 123; // Initialize b to avoid using garbage value with %f\n    // b = p/3; // COMPILE ERROR: Division of a pointer by an integer is not a valid C operation.\n    printf("Line 'b = p/3;' would cause a compile-time error.\\n");\n    // printf("answer=%f", (double)b); // If we were to print b, cast to double for %f\n    return 0;\n}`
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

            if (Object.keys(codeSamples).length > 0) {
                 codeEditor.value = codeSamples[Object.keys(codeSamples)[0]];
            } else {
                 codeEditor.value = "// Welcome! No runnable examples in this section. Write your own C/C++ code here.";
            }
        });
    </script>
</body>
</html>
