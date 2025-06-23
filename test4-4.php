<?php
// 這是一個 PHP 檔案，以確保在支援 PHP 的網頁伺服器上能正確解析和提供服務。
// 即使沒有動態 PHP 程式碼，使用 .php 副檔名也能滿足某些伺服器環境設定。
//程式碼沙箱 (Emscripten / WASM)
//點擊左側「運行示例」或直接編輯，程式碼將透過後端編譯為 WebAssembly 在瀏覽器中執行。
//動態公式渲染器 (MathJax) 本站已整合 MathJax，可優雅地呈現數學與指標運算式。例如：指標 `p` 指向陣列 `arr`，存取第 `i` 個元素：
//計算 `double` 型別的大小：`sizeof(double)`
//二次方程式公式：$x = {-b \pm \sqrt{b^2-4ac} \over 2a}$
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C 語言 第四章 詳細追蹤練習 (WASM & MathJax)</title>

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
            line-height: 1.2; /* Adjusted from 1.8 for potentially more compact tables */
            margin: 0;
            padding: 0;
            overflow: hidden; /* 防止頁面本身滾動 */
        }
        .container {
            display: flex;
            max-width: 100%; /* 使用全部寬度 */
            height: 100vh; /* 佔滿整個視窗高度 */
            margin: 0 auto;
            padding: 0; /* 移除內邊距，由子元素控制 */
        }
        .tutorial-content { /* 左側視窗 */
            width: 70%; /* 初始寬度 */
            min-width: 350px; /* 最小寬度 */
            padding: 20px 40px;
            box-sizing: border-box;
            overflow-y: auto; /* 讓教學內容可以獨立滾動 */
            height: 100vh;
        }
        .resizer {
            width: 8px;
            cursor: col-resize;
            background-color: var(--border-color);
            flex-shrink: 0;
            transition: background-color 0.2s;
        }
        .resizer:hover {
            background-color: var(--primary-color);
        }
        .interactive-panel {  /* 右側視窗 */
            width: 30%; /* 初始寬度 */
            min-width: 400px; /* 最小寬度 */
            flex-grow: 1; /* 佔據剩餘空間 */
            position: relative;
            top: 0;
            height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }

        h1, h2, h3 {
            color: var(--header-color);
            font-weight: 700;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
        }
        h1 { font-size: 2.2em; margin-bottom:20px;} /* Adjusted */
        h2 { font-size: 1.8em; margin-top: 30px; } /* Adjusted */
        h3 { font-size: 1.3em; margin-top: 25px; border-bottom: none; color:var(--primary-color); } /* Adjusted */
        p, ul {
            font-size: 1em; /* Adjusted */
            line-height: 1.7; /* Added for readability */
        }
        ul {
            list-style-type: disc;
            padding-left: 20px;
        }
        li {
            margin-bottom: 8px; /* Adjusted */
        }
        code:not(pre > code) {
            background-color: var(--card-bg);
            color: var(--primary-color);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: var(--font-code);
        }
        pre {
            margin: 1em 0; /* Added margin for pre blocks */
        }
        /* Explanation table styles */
        .explanation table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 15px;
            font-size: 0.9em;
            background-color: var(--code-bg);
        }
        .explanation th, .explanation td {
            border: 1px solid var(--border-color);
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }
        .explanation th {
            background-color: var(--primary-color);
            color: white;
            font-weight: bold;
        }
        .explanation td code { /* For inline code within table cells */
             background-color: rgba(255,255,255,0.1);
             padding: 1px 4px;
        }


        .run-example-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-family: var(--font-body);
            font-weight: 500;
            transition: background-color 0.3s;
            margin-top: 5px; /* Added margin */
            margin-bottom: 10px; /* Added margin */
            font-size: 0.9em;
        }
        .run-example-btn:hover {
            background-color: #357ABD;
        }

        /* Interactive Panel Styles */
        .sandbox-container {
            background-color: var(--card-bg);
            border-radius: 8px;
            padding: 15px; /* Adjusted */
            border: 1px solid var(--border-color);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .interactive-panel-inner {
            display: flex;
            flex-direction: column;
            height: 100%;
            gap: 15px; /* Adjusted */
        }
        .sandbox-container h3 { /* Title for sandbox */
            margin-top: 0;
            color: var(--primary-color);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 8px; /* Adjusted */
            font-size: 1.2em; /* Adjusted */
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
            padding: 8px 0; /* Adjusted */
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
            padding: 10px; /* Adjusted */
            border-radius: 4px;
            font-family: var(--font-code);
            white-space: pre-wrap;
            word-wrap: break-word;
            min-height: 80px;
            margin-top: 8px; /* Adjusted */
            flex-shrink: 0;
            font-size: 0.85em;
            overflow-y: auto;
            max-height: 250px;
        }
        /* Quiz Section Styles */
        .quiz-section {
            margin-top: 30px; /* Adjusted */
            background-color: transparent;
            border: none;
            padding: 0;
        }
        .quiz-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px; /* Adjusted */
            margin-bottom: 20px; /* Adjusted */
            scroll-margin-top: 20px;
        }
        .quiz-card h3 { /* Question title */
            margin-top: 0;
            color: var(--header-color); /* Changed from --primary-color */
            font-size: 1.2em; /* Adjusted */
            border-bottom: 1px dashed var(--border-color); /* Added subtle separator */
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .quiz-options .option {
            display: block;
            background-color: #3c3c3c;
            margin: 8px 0; /* Adjusted */
            padding: 12px; /* Adjusted */
            border-radius: 5px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.3s, background-color 0.3s;
            position: relative; /* For feedback icon */
        }
        .quiz-options .option:hover {
            border-color: var(--primary-color);
        }
        .quiz-options .option.correct {
            border-color: var(--success-color);
            background-color: rgba(115, 201, 144, 0.15); /* Adjusted opacity */
        }
        .quiz-options .option.incorrect {
            border-color: var(--error-color);
            background-color: rgba(244, 113, 116, 0.15); /* Adjusted opacity */
        }
        .quiz-options .option.answered {
            cursor: default;
        }
        .quiz-options .option.answered:hover { /* Keep border color if answered */
            border-color: currentColor;
        }
        .quiz-options .option.correct.answered:hover {
             border-color: var(--success-color);
        }
         .quiz-options .option.incorrect.answered:hover {
             border-color: var(--error-color);
        }
        .feedback-icon { /* For correct/incorrect checkmark */
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.1em;
        }

        .explanation {
            display: none;
            margin-top: 15px; /* Adjusted */
            padding: 15px;  /* Adjusted */
            background-color: rgba(0,0,0,0.1); /* Slightly more subtle */
            border-radius: 5px;
            border: 1px solid var(--border-color);
            line-height: 1.6; /* For better readability of explanation text */
        }
        .explanation h4 { /* Sub-headers in explanation e.g., "✓ 解題思路" */
            margin-top: 0;
            margin-bottom: 10px;
            color: var(--primary-color);
            font-size: 1.1em; /* Adjusted */
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
            margin-top: 15px; /* Adjusted */
        }
        .next-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .next-btn:hover {
            background-color: #357ABD;
        }
    </style>
</head>
<body>

    <div class="container">
        <main class="tutorial-content">
            <h1>C 語言練習：第四章 詳細變數追蹤</h1>
            <p>本頁面提供 C 語言第四章（主要關於迴圈、條件判斷與綜合應用）的互動練習題。每個題目都旨在幫助您更深入地理解程式碼的執行流程。請仔細分析題目，並選擇您認為正確的答案。點擊選項後，將會顯示該題的詳細解說。對於涉及迴圈的題目，解說中會包含「變數變化追蹤表」，以視覺化方式呈現迴圈中各變數在每次迭代的變化情況。您可以利用右側的程式碼沙箱，執行或修改範例程式碼，以加強學習效果。</p>

            <div class="quiz-section">
                <h2>第四章 互動練習題 - 詳細追蹤版</h2>
                <p>請挑戰下面的題目，檢驗您的學習成果！點擊選項後會顯示包含詳細追蹤過程的詳解。</p>
                <!-- QUIZ CARDS START -->
                <div id="q1" class="quiz-card">
                    <h3>1. 已知下列程式碼，則其中 Printout 總共執行幾次？</h3>
                    <pre><code class="language-c">k=6; do {Printout; k=k*2;} while (k&lt;100);</code></pre>
                    <button class="run-example-btn" data-code-id="q1-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 4</div>
                        <div class="option" data-option="B">(B) 5</div>
                        <div class="option" data-option="C">(C) 6</div>
                        <div class="option" data-option="D">(D) 7</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此題使用 <code>do-while</code> 迴圈。變數 <code>k</code> 的初始值為 6。迴圈首先執行一次動作（<code>Printout</code> 並將 <code>k</code> 乘以 2），然後檢查條件 <code>k &lt; 100</code> 是否成立。如果成立，則繼續下一輪迴圈。</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>執行 Printout 次數</th>
                                    <th>迴圈開始前 k</th>
                                    <th>執行動作</th>
                                    <th>迴圈結束後 k</th>
                                    <th>條件檢查 (k &lt; 100)</th>
                                    <th>條件結果</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>-</td><td>6</td><td>-</td><td>-</td><td>-</td><td>(進入迴圈)</td></tr>
                                <tr><td>第 1 次</td><td>6</td><td>Printout; k = 6 * 2</td><td>12</td><td>12 &lt; 100</td><td>True</td></tr>
                                <tr><td>第 2 次</td><td>12</td><td>Printout; k = 12 * 2</td><td>24</td><td>24 &lt; 100</td><td>True</td></tr>
                                <tr><td>第 3 次</td><td>24</td><td>Printout; k = 24 * 2</td><td>48</td><td>48 &lt; 100</td><td>True</td></tr>
                                <tr><td>第 4 次</td><td>48</td><td>Printout; k = 48 * 2</td><td>96</td><td>96 &lt; 100</td><td>True</td></tr>
                                <tr><td>第 5 次</td><td>96</td><td>Printout; k = 96 * 2</td><td>192</td><td>192 &lt; 100</td><td>False (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>當 <code>k</code> 的值變為 192 時，條件 <code>192 &lt; 100</code> 為假，迴圈終止。因此，<code>Printout</code> 總共執行了 5 次。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q2">下一題</button></div>
                </div>

                <div id="q2" class="quiz-card">
                    <h3>2. 設 A 的值為 0000000，B 的值為 1000000，則經過(A OR B) AND (NOT B)運算後的結果為何？</h3>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 0000000</div>
                        <div class="option" data-option="B">(B) 1111111</div>
                        <div class="option" data-option="C">(C) 1000000</div>
                        <div class="option" data-option="D">(D) 0111111</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路</h4>
                        <p>本題考查位元邏輯運算：OR、AND、NOT。</p>
                        <ol>
                            <li><b>A OR B：</b>
                                <pre><code class="language-text">  0000000 (A)
OR 1000000 (B)
----------
  1000000 (Result1)</code></pre>
                            </li>
                            <li><b>NOT B：</b> (假設為7位元反相)
                                <pre><code class="language-text">NOT 1000000 (B)
----------
    0111111 (Result2)</code></pre>
                            </li>
                            <li><b>(A OR B) AND (NOT B)</b> 即 Result1 AND Result2：
                                <pre><code class="language-text">  1000000 (Result1)
AND 0111111 (Result2)
----------
  0000000 (Final Result)</code></pre>
                            </li>
                        </ol>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q3">下一題</button></div>
                </div>

                <div id="q3" class="quiz-card">
                    <h3>3. 當下列程式片段執行完畢後，變數 count 的數值為何？</h3>
                    <pre><code class="language-c">int count=0;
for(int i=5; i&lt;=10; i=i+1)
  for(int j=1; j&lt;=i; j=j+1)
    for (int k=1; k&lt;=j; k=k+1)
      if (i==j) count=count+1;</code></pre>
                    <button class="run-example-btn" data-code-id="q3-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 50</div>
                        <div class="option" data-option="B">(B) 45</div>
                        <div class="option" data-option="C">(C) 30</div>
                        <div class="option" data-option="D">(D) 20</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式使用三層巢狀 <code>for</code> 迴圈。變數 <code>count</code> 只有在最內層迴圈且條件 <code>i == j</code> 成立時才會遞增。我們需要分析外層迴圈 <code>i</code> 和中層迴圈 <code>j</code> 的關係。</p>
                        <p>關鍵在於：當 <code>i == j</code> 時，最內層的 <code>k</code> 迴圈 (<code>for (int k=1; k&lt;=j; k=k+1)</code>) 會執行 <code>j</code> 次（也就是 <code>i</code> 次）。</p>
                        <table>
                            <thead>
                                <tr><th>外層 i</th><th>中層 j</th><th>條件 (i==j)</th><th>count 增加量 (j 次)</th><th>累計 count</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>5 (初始)</td><td>-</td><td>-</td><td>-</td><td>0</td></tr>
                                <tr><td>i=5</td><td>j=1 to 4</td><td>False</td><td>0</td><td>0</td></tr>
                                <tr><td></td><td>j=5</td><td>True</td><td>5 (k從1到5)</td><td>0 + 5 = 5</td></tr>
                                <tr><td>i=6</td><td>j=1 to 5</td><td>False</td><td>0</td><td>5</td></tr>
                                <tr><td></td><td>j=6</td><td>True</td><td>6 (k從1到6)</td><td>5 + 6 = 11</td></tr>
                                <tr><td>i=7</td><td>j=1 to 6</td><td>False</td><td>0</td><td>11</td></tr>
                                <tr><td></td><td>j=7</td><td>True</td><td>7 (k從1到7)</td><td>11 + 7 = 18</td></tr>
                                <tr><td>i=8</td><td>j=1 to 7</td><td>False</td><td>0</td><td>18</td></tr>
                                <tr><td></td><td>j=8</td><td>True</td><td>8 (k從1到8)</td><td>18 + 8 = 26</td></tr>
                                <tr><td>i=9</td><td>j=1 to 8</td><td>False</td><td>0</td><td>26</td></tr>
                                <tr><td></td><td>j=9</td><td>True</td><td>9 (k從1到9)</td><td>26 + 9 = 35</td></tr>
                                <tr><td>i=10</td><td>j=1 to 9</td><td>False</td><td>0</td><td>35</td></tr>
                                <tr><td></td><td>j=10</td><td>True</td><td>10 (k從1到10)</td><td>35 + 10 = 45</td></tr>
                            </tbody>
                        </table>
                        <p>因此，<code>count</code> 的最終值是 5 + 6 + 7 + 8 + 9 + 10 = 45。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q4">下一題</button></div>
                </div>

                <div id="q4" class="quiz-card">
                    <h3>4. 當下列程式片段執行完畢後，變數 x 的數值為何？</h3>
                    <pre><code class="language-c">int n=0; int x=0;
do {
  x += n;
  n++;
} while (n&lt;10);</code></pre>
                    <button class="run-example-btn" data-code-id="q4-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 50</div>
                        <div class="option" data-option="B">(B) 45</div>
                        <div class="option" data-option="C">(C) 30</div>
                        <div class="option" data-option="D">(D) 20</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式碼使用 <code>do-while</code> 迴圈計算從 0 到 9 的整數總和。變數 <code>x</code> 用於累加，<code>n</code> 作為計數器，從0開始遞增。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 n</th><th>執行 x += n</th><th>執行 n++</th><th>迴圈結束後 n</th><th>條件檢查 (n &lt; 10)</th><th>條件結果</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>0</td><td>x = 0 + 0 = 0</td><td>n = 1</td><td>1</td><td>1 &lt; 10</td><td>True</td></tr>
                                <tr><td>1</td><td>x = 0 + 1 = 1</td><td>n = 2</td><td>2</td><td>2 &lt; 10</td><td>True</td></tr>
                                <tr><td>2</td><td>x = 1 + 2 = 3</td><td>n = 3</td><td>3</td><td>3 &lt; 10</td><td>True</td></tr>
                                <tr><td>3</td><td>x = 3 + 3 = 6</td><td>n = 4</td><td>4</td><td>4 &lt; 10</td><td>True</td></tr>
                                <tr><td>4</td><td>x = 6 + 4 = 10</td><td>n = 5</td><td>5</td><td>5 &lt; 10</td><td>True</td></tr>
                                <tr><td>5</td><td>x = 10 + 5 = 15</td><td>n = 6</td><td>6</td><td>6 &lt; 10</td><td>True</td></tr>
                                <tr><td>6</td><td>x = 15 + 6 = 21</td><td>n = 7</td><td>7</td><td>7 &lt; 10</td><td>True</td></tr>
                                <tr><td>7</td><td>x = 21 + 7 = 28</td><td>n = 8</td><td>8</td><td>8 &lt; 10</td><td>True</td></tr>
                                <tr><td>8</td><td>x = 28 + 8 = 36</td><td>n = 9</td><td>9</td><td>9 &lt; 10</td><td>True</td></tr>
                                <tr><td>9</td><td>x = 36 + 9 = 45</td><td>n = 10</td><td>10</td><td>10 &lt; 10</td><td>False (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>當 <code>n</code> 增加到 10 時，<code>while</code> 條件 <code>(10 < 10)</code> 判斷為 false，迴圈結束。最終 <code>x</code> 的值是 0 到 9 的總和，即 45。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q5">下一題</button></div>
                </div>

                <div id="q5" class="quiz-card">
                    <h3>5. 下列程式碼，while 迴圈內 i = i ＊ i 被執行多少次？</h3>
                    <pre><code class="language-c">int i= 2; while (i &lt; 800) {i = i * i;}</code></pre>
                    <button class="run-example-btn" data-code-id="q5-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 2</div>
                        <div class="option" data-option="B">(B) 3</div>
                        <div class="option" data-option="C">(C) 4</div>
                        <div class="option" data-option="D">(D) 5</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式碼使用 <code>while</code> 迴圈。變數 <code>i</code> 的初始值為 2。在每次迴圈中，<code>i</code> 的值會變成其自身的平方 (<code>i = i * i</code>)。迴圈持續的條件是 <code>i < 800</code>。</p>
                        <table>
                            <thead>
                                <tr><th>執行 <code>i=i*i</code> 次數</th><th>迴圈開始前 i</th><th>條件檢查 (i &lt; 800)</th><th>條件結果</th><th>執行 i = i * i</th><th>迴圈結束後 i</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>-</td><td>2 (初始)</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
                                <tr><td>第 1 次</td><td>2</td><td>2 &lt; 800</td><td>True</td><td>i = 2 * 2 = 4</td><td>4</td></tr>
                                <tr><td>第 2 次</td><td>4</td><td>4 &lt; 800</td><td>True</td><td>i = 4 * 4 = 16</td><td>16</td></tr>
                                <tr><td>第 3 次</td><td>16</td><td>16 &lt; 800</td><td>True</td><td>i = 16 * 16 = 256</td><td>256</td></tr>
                                <tr><td>第 4 次</td><td>256</td><td>256 &lt; 800</td><td>True</td><td>i = 256 * 256 = 65536</td><td>65536</td></tr>
                                <tr><td>-</td><td>65536</td><td>65536 &lt; 800</td><td>False</td><td>- (不執行)</td><td>65536 (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>當 <code>i</code> 的值變為 65536 時，條件 <code>65536 &lt; 800</code> 為假，迴圈終止。因此，敘述 <code>i = i * i</code> 總共執行了 4 次。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q6">下一題</button></div>
                </div>

                <div id="q6" class="quiz-card">
                    <h3>6. 下列程式，印出多少個 happy？</h3>
                    <pre><code class="language-c">int i = 1; // Corrected initialization
while (i &lt;= 10) puts("happy");</code></pre>
                    <button class="run-example-btn" data-code-id="q6-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 0</div>
                        <div class="option" data-option="B">(B) 1</div>
                        <div class="option" data-option="C">(C) 0</div>
                        <div class="option" data-option="D">(D) 無限個</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式碼片段初始化變數 <code>i</code> 為 1。接著進入一個 <code>while</code> 迴圈，條件是 <code>i &lt;= 10</code>。在迴圈體內，它會呼叫 <code>puts("happy")</code> 來印出 "happy"。</p>
                        <p>關鍵點在於，迴圈體內並沒有任何語句去修改變數 <code>i</code> 的值。因此，<code>i</code> 的值將永遠保持為 1。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 i</th><th>條件檢查 (i &lt;= 10)</th><th>條件結果</th><th>動作</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>1 (初始)</td><td>-</td><td>-</td><td>-</td></tr>
                                <tr><td>1</td><td>1 &lt;= 10</td><td>True</td><td>puts("happy")</td></tr>
                                <tr><td>1</td><td>1 &lt;= 10</td><td>True</td><td>puts("happy")</td></tr>
                                <tr><td>1</td><td>1 &lt;= 10</td><td>True</td><td>puts("happy")</td></tr>
                                <tr><td colspan="4" style="text-align:center;">... 此過程無限重複 ...</td></tr>
                            </tbody>
                        </table>
                        <p>由於 <code>i</code> 的值始終為 1，條件 <code>i &lt;= 10</code> 一直為真，導致迴圈無限執行下去，不斷印出 "happy"。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q7">下一題</button></div>
                </div>

                <div id="q7" class="quiz-card">
                    <h3>7. 下面 f( )函式執行後所回傳的值為何？</h3>
                    <pre><code class="language-c">int f(){
  int p=2;
  while(p&lt;2000){
    p=2*p;
  }
  return p;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q7-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 1023</div>
                        <div class="option" data-option="B">(B) 1024</div>
                        <div class="option" data-option="C">(C) 2047</div>
                        <div class="option" data-option="D">(D) 2048</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>函式 <code>f</code> 初始化整數變數 <code>p</code> 為 2。然後進入一個 <code>while</code> 迴圈，只要 <code>p < 2000</code>，迴圈就會執行，將 <code>p</code> 的值乘以 2。當條件不滿足時，迴圈結束，函式回傳 <code>p</code> 的最終值。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 p</th><th>條件檢查 (p &lt; 2000)</th><th>條件結果</th><th>執行 p = 2 * p</th><th>迴圈結束後 p</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>2 (初始)</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
                                <tr><td>2</td><td>2 &lt; 2000</td><td>True</td><td>p = 2 * 2 = 4</td><td>4</td></tr>
                                <tr><td>4</td><td>4 &lt; 2000</td><td>True</td><td>p = 2 * 4 = 8</td><td>8</td></tr>
                                <tr><td>8</td><td>8 &lt; 2000</td><td>True</td><td>p = 2 * 8 = 16</td><td>16</td></tr>
                                <tr><td>16</td><td>16 &lt; 2000</td><td>True</td><td>p = 2 * 16 = 32</td><td>32</td></tr>
                                <tr><td>32</td><td>32 &lt; 2000</td><td>True</td><td>p = 2 * 32 = 64</td><td>64</td></tr>
                                <tr><td>64</td><td>64 &lt; 2000</td><td>True</td><td>p = 2 * 64 = 128</td><td>128</td></tr>
                                <tr><td>128</td><td>128 &lt; 2000</td><td>True</td><td>p = 2 * 128 = 256</td><td>256</td></tr>
                                <tr><td>256</td><td>256 &lt; 2000</td><td>True</td><td>p = 2 * 256 = 512</td><td>512</td></tr>
                                <tr><td>512</td><td>512 &lt; 2000</td><td>True</td><td>p = 2 * 512 = 1024</td><td>1024</td></tr>
                                <tr><td>1024</td><td>1024 &lt; 2000</td><td>True</td><td>p = 2 * 1024 = 2048</td><td>2048</td></tr>
                                <tr><td>2048</td><td>2048 &lt; 2000</td><td>False</td><td>- (不執行)</td><td>2048 (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>當 <code>p</code> 變為 2048 時，條件 <code>2048 &lt; 2000</code> 為假，迴圈結束。函式回傳 <code>p</code> 的值，即 2048。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q8">下一題</button></div>
                </div>

                <div id="q8" class="quiz-card">
                    <h3>8. 一個迴圈程式碼如下，其中 m = m / k 總共執行幾次？</h3>
                    <pre><code class="language-c">int k = 2; int m=10000; // Corrected initialization
do {
  m = m / k;
  k = k * 3;
} while (k&lt;120);</code></pre>
                    <button class="run-example-btn" data-code-id="q8-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 3 次</div>
                        <div class="option" data-option="B">(B) 4 次</div>
                        <div class="option" data-option="C">(C) 5 次</div>
                        <div class="option" data-option="D">(D) 6 次</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式碼使用 <code>do-while</code> 迴圈。變數 <code>k</code> 初始為 2，<code>m</code> 初始為 10000。迴圈體先執行一次，然後檢查條件 <code>k &lt; 120</code>。</p>
                        <table>
                            <thead>
                                <tr><th>執行 <code>m=m/k</code> 次數</th><th>迴圈開始前 k</th><th>迴圈開始前 m</th><th>執行 <code>m=m/k</code></th><th>執行 <code>k=k*3</code></th><th>迴圈結束後 k</th><th>條件 (k &lt; 120)</th><th>條件結果</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>-</td><td>2</td><td>10000</td><td>-</td><td>-</td><td>-</td><td>-</td><td>(進入迴圈)</td></tr>
                                <tr><td>第 1 次</td><td>2</td><td>10000</td><td>m = 10000 / 2 = 5000</td><td>k = 2 * 3 = 6</td><td>6</td><td>6 &lt; 120</td><td>True</td></tr>
                                <tr><td>第 2 次</td><td>6</td><td>5000</td><td>m = 5000 / 6 = 833</td><td>k = 6 * 3 = 18</td><td>18</td><td>18 &lt; 120</td><td>True</td></tr>
                                <tr><td>第 3 次</td><td>18</td><td>833</td><td>m = 833 / 18 = 46</td><td>k = 18 * 3 = 54</td><td>54</td><td>54 &lt; 120</td><td>True</td></tr>
                                <tr><td>第 4 次</td><td>54</td><td>46</td><td>m = 46 / 54 = 0</td><td>k = 54 * 3 = 162</td><td>162</td><td>162 &lt; 120</td><td>False (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>當 <code>k</code> 變為 162 時，條件 <code>162 &lt; 120</code> 為假，迴圈終止。因此，敘述 <code>m = m / k</code> 總共執行了 4 次。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q9">下一題</button></div>
                </div>

                <div id="q9" class="quiz-card">
                    <h3>9. 執行下列程式片段，請問最後 x 的值多少？</h3>
                    <pre><code class="language-c">int x = 50; int y = 90;
if (y&lt;95)
  if (y&lt;200) x = 30;
  else x =45;
// printf("x = %d", x); // Original code has printf, but question asks for x's value.
</code></pre>
                    <button class="run-example-btn" data-code-id="q9-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 30</div>
                        <div class="option" data-option="B">(B) 50</div>
                        <div class="option" data-option="C">(C) 45</div>
                        <div class="option" data-option="D">(D) 90</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路</h4>
                        <ol>
                            <li>變數初始化：<code>x = 50</code>，<code>y = 90</code>。</li>
                            <li>外層 <code>if</code> 條件：<code>(y < 95)</code> 即 <code>(90 < 95)</code>。此條件為真 (True)。</li>
                            <li>由於外層條件為真，程式進入內層 <code>if</code> 判斷。C 語言中，<code>else</code> 與最近的未配對 <code>if</code> 結合。在此，<code>else x = 45;</code> 與內層的 <code>if (y<200)</code> 配對。</li>
                            <li>內層 <code>if</code> 條件：<code>(y < 200)</code> 即 <code>(90 < 200)</code>。此條件為真 (True)。</li>
                            <li>由於內層條件為真，執行 <code>x = 30;</code>。變數 <code>x</code> 的值變為 30。</li>
                            <li>內層 <code>if</code> 的 <code>else</code> 部分 (<code>else x = 45;</code>) 不會被執行。</li>
                        </ol>
                        <p>最終 <code>x</code> 的值為 30。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q10">下一題</button></div>
                </div>

                <div id="q10" class="quiz-card">
                    <h3>10. 執行下列程式碼之後，請問最後 s 的值多少？</h3>
                    <pre><code class="language-c">int s = 0;
for (int i=2; i&lt;=100; i+=2) s+=i;
// printf("s = %d", s); // Original code has printf
</code></pre>
                    <button class="run-example-btn" data-code-id="q10-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 5500</div>
                        <div class="option" data-option="B">(B) 2550</div>
                        <div class="option" data-option="C">(C) 5050</div>
                        <div class="option" data-option="D">(D) 2500</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式碼使用 <code>for</code> 迴圈計算從 2 到 100 之間所有偶數的總和。變數 <code>s</code> 用於累加總和，迴圈變數 <code>i</code> 從 2 開始，每次增加 2，直到 <code>i</code> 超過 100。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈變數 i</th><th>條件 (i &lt;= 100)</th><th>條件結果</th><th>執行 s += i (目前 s 值)</th><th>迴圈後 s</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>2 (初始)</td><td>2 &lt;= 100</td><td>True</td><td>s = 0 + 2 = 2</td><td>2</td></tr>
                                <tr><td>4</td><td>4 &lt;= 100</td><td>True</td><td>s = 2 + 4 = 6</td><td>6</td></tr>
                                <tr><td>6</td><td>6 &lt;= 100</td><td>True</td><td>s = 6 + 6 = 12</td><td>12</td></tr>
                                <tr><td colspan="5" style="text-align:center;">... 繼續累加 ...</td></tr>
                                <tr><td>98</td><td>98 &lt;= 100</td><td>True</td><td>s = (sum of 2..96) + 98 = 2450</td><td>2450</td></tr>
                                <tr><td>100</td><td>100 &lt;= 100</td><td>True</td><td>s = 2450 + 100 = 2550</td><td>2550</td></tr>
                                <tr><td>102 (i+=2 後)</td><td>102 &lt;= 100</td><td>False</td><td>- (不執行)</td><td>2550 (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>這是一個等差數列求和：2 + 4 + ... + 100。
                        首項 a1 = 2，末項 an = 100，公差 d = 2。
                        項數 n = (an - a1)/d + 1 = (100 - 2)/2 + 1 = 98/2 + 1 = 49 + 1 = 50 項。
                        總和 S = n * (a1 + an) / 2 = 50 * (2 + 100) / 2 = 50 * 102 / 2 = 50 * 51 = 2550。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q11">下一題</button></div>
                </div>

                <div id="q11" class="quiz-card">
                    <h3>11. 執行下列程式後，請問最後 i 的值多少？</h3>
                    <pre><code class="language-c">int i;
for (i = 7; i &lt;= 72; i += 7)
  ; // 空迴圈敘述
// printf("i is %d", i); // Original code has printf
</code></pre>
                    <button class="run-example-btn" data-code-id="q11-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 77</div>
                        <div class="option" data-option="B">(B) 70</div>
                        <div class="option" data-option="C">(C) 72</div>
                        <div class="option" data-option="D">(D) 7</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式碼使用一個 <code>for</code> 迴圈，但迴圈體是一個空敘述 (僅有一個分號 <code>;</code>)。這表示迴圈的條件檢查和遞增部分會正常執行，但每次迭代時不會執行任何特定的動作。我們需要追蹤變數 <code>i</code> 的值。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 i</th><th>條件檢查 (i &lt;= 72)</th><th>條件結果</th><th>執行 i += 7</th><th>迴圈結束後 i</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>7 (初始)</td><td>7 &lt;= 72</td><td>True</td><td>i = 7 + 7 = 14</td><td>14</td></tr>
                                <tr><td>14</td><td>14 &lt;= 72</td><td>True</td><td>i = 14 + 7 = 21</td><td>21</td></tr>
                                <tr><td>21</td><td>21 &lt;= 72</td><td>True</td><td>i = 21 + 7 = 28</td><td>28</td></tr>
                                <tr><td>28</td><td>28 &lt;= 72</td><td>True</td><td>i = 28 + 7 = 35</td><td>35</td></tr>
                                <tr><td>35</td><td>35 &lt;= 72</td><td>True</td><td>i = 35 + 7 = 42</td><td>42</td></tr>
                                <tr><td>42</td><td>42 &lt;= 72</td><td>True</td><td>i = 42 + 7 = 49</td><td>49</td></tr>
                                <tr><td>49</td><td>49 &lt;= 72</td><td>True</td><td>i = 49 + 7 = 56</td><td>56</td></tr>
                                <tr><td>56</td><td>56 &lt;= 72</td><td>True</td><td>i = 56 + 7 = 63</td><td>63</td></tr>
                                <tr><td>63</td><td>63 &lt;= 72</td><td>True</td><td>i = 63 + 7 = 70</td><td>70</td></tr>
                                <tr><td>70</td><td>70 &lt;= 72</td><td>True</td><td>i = 70 + 7 = 77</td><td>77</td></tr>
                                <tr><td>77</td><td>77 &lt;= 72</td><td>False</td><td>- (不執行)</td><td>77 (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>當 <code>i</code> 的值變為 77 時，條件 <code>77 &lt;= 72</code> 為假，迴圈終止。<code>i</code> 的最終值為 77。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q15">下一題</button></div>
                </div>

                <div id="q15" class="quiz-card">
                    <h3>15. 布林代數式 A+A+A 等於：</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 3A</div>
                        <div class="option" data-option="B">(B) 2A</div>
                        <div class="option" data-option="C">(C) A</div>
                        <div class="option" data-option="D">(D) 1</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路</h4>
                        <p>本題考查布林代數的等冪律 (Idempotent Law) for OR operation。</p>
                        <p>在布林代數中，對於 OR 運算 (通常用 `+` 表示)：</p>
                        <ul>
                            <li><code>A + A = A</code></li>
                        </ul>
                        <p>我們可以逐步簡化表達式 <code>A+A+A</code>：</p>
                        <ol>
                            <li>將前兩項分組：<code>(A + A) + A</code></li>
                            <li>根據等冪律，<code>(A + A)</code> 等於 <code>A</code>。</li>
                            <li>所以表達式變為：<code>A + A</code></li>
                            <li>再次應用等冪律，<code>A + A</code> 等於 <code>A</code>。</li>
                        </ol>
                        <p>因此，<code>A+A+A = A</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q16">下一題</button></div>
                </div>

                <div id="q16" class="quiz-card">
                    <h3>16. 一個迴圈程式碼： k = 10000， while (k >=2) { k=k/8， } 其中 k=k/8 總共會執行幾次？</h3>
                    <pre><code class="language-c">/* Conceptual code:
int k = 10000;
int count = 0;
while (k >= 2) {
    k = k / 8; // Integer division
    count++;
}
*/</code></pre>
                    <button class="run-example-btn" data-code-id="q16-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 3 次</div>
                        <div class="option" data-option="B">(B) 4 次</div>
                        <div class="option" data-option="C">(C) 5 次</div>
                        <div class="option" data-option="D">(D) 6 次</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式碼使用 <code>while</code> 迴圈。變數 <code>k</code> 初始值為 10000。在每次迴圈中，<code>k</code> 的值會變成 <code>k / 8</code> (整數除法)。迴圈持續的條件是 <code>k >= 2</code>。</p>
                        <table>
                            <thead>
                                <tr><th>執行 <code>k=k/8</code> 次數</th><th>迴圈開始前 k</th><th>條件檢查 (k >= 2)</th><th>條件結果</th><th>執行 k = k / 8</th><th>迴圈結束後 k</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>-</td><td>10000 (初始)</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
                                <tr><td>第 1 次</td><td>10000</td><td>10000 >= 2</td><td>True</td><td>k = 10000 / 8 = 1250</td><td>1250</td></tr>
                                <tr><td>第 2 次</td><td>1250</td><td>1250 >= 2</td><td>True</td><td>k = 1250 / 8 = 156</td><td>156</td></tr>
                                <tr><td>第 3 次</td><td>156</td><td>156 >= 2</td><td>True</td><td>k = 156 / 8 = 19</td><td>19</td></tr>
                                <tr><td>第 4 次</td><td>19</td><td>19 >= 2</td><td>True</td><td>k = 19 / 8 = 2</td><td>2</td></tr>
                                <tr><td>第 5 次</td><td>2</td><td>2 >= 2</td><td>True</td><td>k = 2 / 8 = 0</td><td>0</td></tr>
                                <tr><td>-</td><td>0</td><td>0 >= 2</td><td>False</td><td>- (不執行)</td><td>0 (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>當 <code>k</code> 的值變為 0 時，條件 <code>0 >= 2</code> 為假，迴圈終止。因此，敘述 <code>k = k / 8</code> 總共執行了 5 次。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q17">下一題</button></div>
                </div>

                <div id="q17" class="quiz-card">
                    <h3>17. 下列程式碼，while 迴圈內 i = i * i 被執行多少次？</h3> <!-- Note: Original question had ＊ -->
                    <pre><code class="language-c">int i=2;
while(i&lt;800) {i=i*i;}</code></pre>
                    <button class="run-example-btn" data-code-id="q17-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 2</div>
                        <div class="option" data-option="B">(B) 3</div>
                        <div class="option" data-option="C">(C) 4</div>
                        <div class="option" data-option="D">(D) 5</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>變數 <code>i</code> 的初始值為 2。在每次迴圈中，<code>i</code> 的值會變成其自身的平方 (<code>i = i * i</code>)。迴圈持續的條件是 <code>i < 800</code>。</p>
                        <table>
                            <thead>
                                <tr><th>執行 <code>i=i*i</code> 次數</th><th>迴圈開始前 i</th><th>條件檢查 (i &lt; 800)</th><th>條件結果</th><th>執行 i = i * i</th><th>迴圈結束後 i</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>-</td><td>2 (初始)</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
                                <tr><td>第 1 次</td><td>2</td><td>2 &lt; 800</td><td>True</td><td>i = 2 * 2 = 4</td><td>4</td></tr>
                                <tr><td>第 2 次</td><td>4</td><td>4 &lt; 800</td><td>True</td><td>i = 4 * 4 = 16</td><td>16</td></tr>
                                <tr><td>第 3 次</td><td>16</td><td>16 &lt; 800</td><td>True</td><td>i = 16 * 16 = 256</td><td>256</td></tr>
                                <tr><td>第 4 次</td><td>256</td><td>256 &lt; 800</td><td>True</td><td>i = 256 * 256 = 65536</td><td>65536</td></tr>
                                <tr><td>-</td><td>65536</td><td>65536 &lt; 800</td><td>False</td><td>- (不執行)</td><td>65536 (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>當 <code>i</code> 的值變為 65536 時，條件 <code>65536 &lt; 800</code> 為假，迴圈終止。因此，敘述 <code>i = i * i</code> 總共執行了 4 次。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q18">下一題</button></div>
                </div>

                <div id="q18" class="quiz-card">
                    <h3>18. 執行下列 c 程式片段，請問最後輸出是？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){ // Corrected from void main
  int number=1061130, result;
  do {
    result = number %10;
    printf("%i", result);
    number = number/10;
  } while(number != 0);
  printf("\n");
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q18-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 1061130</div>
                        <div class="option" data-option="B">(B) 0311601</div>
                        <div class="option" data-option="C">(C) 106113</div>
                        <div class="option" data-option="D">(D) 311601</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式使用 <code>do-while</code> 迴圈來反向印出一個整數的每一位數。變數 <code>number</code> 初始值為 1061130。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 number</th><th>result = number % 10</th><th>printf("%i", result)</th><th>number = number / 10</th><th>條件 (number != 0)</th><th>條件結果</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>1061130</td><td>0</td><td>印出 0</td><td>106113</td><td>106113 != 0</td><td>True</td></tr>
                                <tr><td>106113</td><td>3</td><td>印出 3</td><td>10611</td><td>10611 != 0</td><td>True</td></tr>
                                <tr><td>10611</td><td>1</td><td>印出 1</td><td>1061</td><td>1061 != 0</td><td>True</td></tr>
                                <tr><td>1061</td><td>1</td><td>印出 1</td><td>106</td><td>106 != 0</td><td>True</td></tr>
                                <tr><td>106</td><td>6</td><td>印出 6</td><td>10</td><td>10 != 0</td><td>True</td></tr>
                                <tr><td>10</td><td>0</td><td>印出 0</td><td>1</td><td>1 != 0</td><td>True</td></tr>
                                <tr><td>1</td><td>1</td><td>印出 1</td><td>0</td><td>0 != 0</td><td>False (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>程式輸出的順序是從個位數開始，所以最終輸出為 0311601。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q19">下一題</button></div>
                </div>

                <div id="q19" class="quiz-card">
                    <h3>19. 執行下列 c 程式片段，請問輸出為下列何項？</h3>
                    <pre><code class="language-c">int x=4; int sum=0;
while (x&lt;=100){
  sum+=x;
  x+=4;
}
// printf("sum=%d", sum); // Original has printf
</code></pre>
                    <button class="run-example-btn" data-code-id="q19-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 325</div>
                        <div class="option" data-option="B">(B) 1300</div>
                        <div class="option" data-option="C">(C) 625</div>
                        <div class="option" data-option="D">(D) 2600</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式碼使用 <code>while</code> 迴圈計算從 4 開始，每次遞增 4，直到 100 (包含100) 的所有數的總和。變數 <code>sum</code> 用於累加，<code>x</code> 為迴圈控制變數。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 x</th><th>條件 (x &lt;= 100)</th><th>條件結果</th><th>執行 sum += x (目前 sum)</th><th>執行 x += 4</th><th>迴圈結束後 x</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>4 (初始)</td><td>4 &lt;= 100</td><td>True</td><td>sum = 0 + 4 = 4</td><td>x = 4 + 4 = 8</td><td>8</td></tr>
                                <tr><td>8</td><td>8 &lt;= 100</td><td>True</td><td>sum = 4 + 8 = 12</td><td>x = 8 + 4 = 12</td><td>12</td></tr>
                                <tr><td colspan="6" style="text-align:center;">... 繼續累加 ...</td></tr>
                                <tr><td>96</td><td>96 &lt;= 100</td><td>True</td><td>sum = (sum of 4..92) + 96 = 1200</td><td>x = 96 + 4 = 100</td><td>100</td></tr>
                                <tr><td>100</td><td>100 &lt;= 100</td><td>True</td><td>sum = 1200 + 100 = 1300</td><td>x = 100 + 4 = 104</td><td>104</td></tr>
                                <tr><td>104</td><td>104 &lt;= 100</td><td>False</td><td>- (不執行)</td><td>104 (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>這是一個等差數列求和：4 + 8 + 12 + ... + 100。
                        首項 a1 = 4，末項 an = 100，公差 d = 4。
                        項數 n = (an - a1)/d + 1 = (100 - 4)/4 + 1 = 96/4 + 1 = 24 + 1 = 25 項。
                        總和 S = n * (a1 + an) / 2 = 25 * (4 + 100) / 2 = 25 * 104 / 2 = 25 * 52 = 1300。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q21">下一題</button></div>
                </div>

                <div id="q21" class="quiz-card">
                    <h3>21. 已知一個迴圈程式碼：k=2， while(k&lt;=65535) k=k*k， 估計其中 k=k*k 總共執行多少次？</h3>
                    <pre><code class="language-c">/* Conceptual:
int k=2;
int count = 0;
while(k&lt;=65535) {
    k=k*k; // Assuming k can hold large values for this estimation
    count++;
}
*/</code></pre>
                    <button class="run-example-btn" data-code-id="q21-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 4 次</div>
                        <div class="option" data-option="B">(B) 5 次</div>
                        <div class="option" data-option="C">(C) 6 次</div>
                        <div class="option" data-option="D">(D) 7 次</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>變數 <code>k</code> 初始值為 2。在每次迴圈中，<code>k</code> 的值會變成其自身的平方 (<code>k = k * k</code>)。迴圈持續的條件是 <code>k &lt;= 65535</code>。我們假設 <code>k</code> 的型別足以容納這些數值而不發生溢位，以便估計執行次數。</p>
                        <table>
                            <thead>
                                <tr><th>執行 <code>k=k*k</code> 次數</th><th>迴圈開始前 k</th><th>條件檢查 (k &lt;= 65535)</th><th>條件結果</th><th>執行 k = k * k</th><th>迴圈結束後 k</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>-</td><td>2 (初始)</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
                                <tr><td>第 1 次</td><td>2</td><td>2 &lt;= 65535</td><td>True</td><td>k = 2 * 2 = 4</td><td>4</td></tr>
                                <tr><td>第 2 次</td><td>4</td><td>4 &lt;= 65535</td><td>True</td><td>k = 4 * 4 = 16</td><td>16</td></tr>
                                <tr><td>第 3 次</td><td>16</td><td>16 &lt;= 65535</td><td>True</td><td>k = 16 * 16 = 256</td><td>256</td></tr>
                                <tr><td>第 4 次</td><td>256</td><td>256 &lt;= 65535</td><td>True</td><td>k = 256 * 256 = 65536</td><td>65536</td></tr>
                                <tr><td>-</td><td>65536</td><td>65536 &lt;= 65535</td><td>False</td><td>- (不執行)</td><td>65536 (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>當 <code>k</code> 的值變為 65536 時，條件 <code>65536 &lt;= 65535</code> 為假，迴圈終止。因此，敘述 <code>k = k * k</code> 總共執行了 4 次。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q22">下一題</button></div>
                </div>

                <div id="q22" class="quiz-card">
                    <h3>22. 下面這一段程式的執行結果 n 的值為何？</h3>
                    <pre><code class="language-c">int n=0; int i=1;
while(i&lt;=100){
  n=n+i;
  i=i+2;
}
// printf("%d\n", n); // Original code has printf
</code></pre>
                    <button class="run-example-btn" data-code-id="q22-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 2000</div>
                        <div class="option" data-option="B">(B) 2500</div>
                        <div class="option" data-option="C">(C) 5000</div>
                        <div class="option" data-option="D">(D) 10000</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式碼使用 <code>while</code> 迴圈計算從 1 開始，每次遞增 2 (即所有奇數)，直到 <code>i</code> 超過 100 時的總和。變數 <code>n</code> 用於累加總和，<code>i</code> 從 1 開始，每次增加 2。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 i</th><th>條件 (i &lt;= 100)</th><th>條件結果</th><th>執行 n += i (目前 n)</th><th>執行 i += 2</th><th>迴圈結束後 i</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>1 (初始)</td><td>1 &lt;= 100</td><td>True</td><td>n = 0 + 1 = 1</td><td>i = 1 + 2 = 3</td><td>3</td></tr>
                                <tr><td>3</td><td>3 &lt;= 100</td><td>True</td><td>n = 1 + 3 = 4</td><td>i = 3 + 2 = 5</td><td>5</td></tr>
                                <tr><td colspan="6" style="text-align:center;">... 繼續累加 ...</td></tr>
                                <tr><td>97</td><td>97 &lt;= 100</td><td>True</td><td>n = (sum of 1..95) + 97 = 2401</td><td>i = 97 + 2 = 99</td><td>99</td></tr>
                                <tr><td>99</td><td>99 &lt;= 100</td><td>True</td><td>n = 2401 + 99 = 2500</td><td>i = 99 + 2 = 101</td><td>101</td></tr>
                                <tr><td>101</td><td>101 &lt;= 100</td><td>False</td><td>- (不執行)</td><td>101 (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>這是一個等差數列求和：1 + 3 + 5 + ... + 99。
                        首項 a1 = 1，末項 an = 99，公差 d = 2。
                        項數 N = (an - a1)/d + 1 = (99 - 1)/2 + 1 = 98/2 + 1 = 49 + 1 = 50 項。
                        總和 S = N * (a1 + an) / 2 = 50 * (1 + 99) / 2 = 50 * 100 / 2 = 50 * 50 = 2500。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q24">下一題</button></div>
                </div>

                <div id="q24" class="quiz-card">
                    <h3>24. 執行下列 c 程式後，請問 y3 最後輸出是？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int y1, y2=13, y3=1;
  for (y1=0; y1&lt;=y2; /* y3 not in increment */ ){
    y3 += y1;
    y1 += 2;
  }
  // printf("%i", y3); // Original code has printf
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q24-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 31</div>
                        <div class="option" data-option="B">(B) 43</div>
                        <div class="option" data-option="C">(C) 57</div>
                        <div class="option" data-option="D">(D) 73</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式使用 <code>for</code> 迴圈。變數 <code>y1</code> 從 0 開始，每次迴圈體執行後增加 2。變數 <code>y3</code> 初始為 1，並在迴圈體內累加 <code>y1</code> 的值。迴圈的條件是 <code>y1 &lt;= y2</code> (即 <code>y1 &lt;= 13</code>)。注意 <code>for</code> 迴圈的第三部分（通常用於變數遞增）是空的，但 <code>y1</code> 在迴圈體內被修改。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 y1</th><th>迴圈開始前 y3</th><th>條件 (y1 &lt;= 13)</th><th>條件結果</th><th>執行 y3 += y1</th><th>執行 y1 += 2</th><th>迴圈結束後 y1</th><th>迴圈結束後 y3</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>0 (初始)</td><td>1 (初始)</td><td>0 &lt;= 13</td><td>True</td><td>y3 = 1 + 0 = 1</td><td>y1 = 0 + 2 = 2</td><td>2</td><td>1</td></tr>
                                <tr><td>2</td><td>1</td><td>2 &lt;= 13</td><td>True</td><td>y3 = 1 + 2 = 3</td><td>y1 = 2 + 2 = 4</td><td>4</td><td>3</td></tr>
                                <tr><td>4</td><td>3</td><td>4 &lt;= 13</td><td>True</td><td>y3 = 3 + 4 = 7</td><td>y1 = 4 + 2 = 6</td><td>6</td><td>7</td></tr>
                                <tr><td>6</td><td>7</td><td>6 &lt;= 13</td><td>True</td><td>y3 = 7 + 6 = 13</td><td>y1 = 6 + 2 = 8</td><td>8</td><td>13</td></tr>
                                <tr><td>8</td><td>13</td><td>8 &lt;= 13</td><td>True</td><td>y3 = 13 + 8 = 21</td><td>y1 = 8 + 2 = 10</td><td>10</td><td>21</td></tr>
                                <tr><td>10</td><td>21</td><td>10 &lt;= 13</td><td>True</td><td>y3 = 21 + 10 = 31</td><td>y1 = 10 + 2 = 12</td><td>12</td><td>31</td></tr>
                                <tr><td>12</td><td>31</td><td>12 &lt;= 13</td><td>True</td><td>y3 = 31 + 12 = 43</td><td>y1 = 12 + 2 = 14</td><td>14</td><td>43</td></tr>
                                <tr><td>14</td><td>43</td><td>14 &lt;= 13</td><td>False</td><td>- (不執行)</td><td>-</td><td>14</td><td>43 (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>當 <code>y1</code> 變為 14 時，條件 <code>14 &lt;= 13</code> 為假，迴圈終止。最終 <code>y3</code> 的值為 43。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q25">下一題</button></div>
                </div>

                <div id="q25" class="quiz-card">
                    <h3>25. 在程式片段中，若輸入 n 為 1234，請問執行結果為何？</h3>
                    <pre><code class="language-c">int  n; int sum=0;
// scanf("%d", &n); // Assuming n = 1234 for this trace
n = 1234; // For tracing
while(n!=0){
  sum=sum+n%10;
  n=n/10;
}
// printf("%d\n", sum); // Original code has printf
</code></pre>
                    <p><sub>(註：右側沙箱不支援 `scanf`，您可以修改程式碼，將 `n` 直接賦值為 1234 進行測試。)</sub></p>
                    <button class="run-example-btn" data-code-id="q25-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 1234</div>
                        <div class="option" data-option="B">(B) 10</div>
                        <div class="option" data-option="C">(C) 1</div>
                        <div class="option" data-option="D">(D) 4</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式碼計算輸入整數 <code>n</code> 的各位數字之和。假設輸入 <code>n = 1234</code>。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 n</th><th>迴圈開始前 sum</th><th>條件 (n != 0)</th><th>條件結果</th><th>n % 10</th><th>sum = sum + (n % 10)</th><th>n = n / 10</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>1234</td><td>0</td><td>1234 != 0</td><td>True</td><td>4</td><td>sum = 0 + 4 = 4</td><td>123</td></tr>
                                <tr><td>123</td><td>4</td><td>123 != 0</td><td>True</td><td>3</td><td>sum = 4 + 3 = 7</td><td>12</td></tr>
                                <tr><td>12</td><td>7</td><td>12 != 0</td><td>True</td><td>2</td><td>sum = 7 + 2 = 9</td><td>1</td></tr>
                                <tr><td>1</td><td>9</td><td>1 != 0</td><td>True</td><td>1</td><td>sum = 9 + 1 = 10</td><td>0</td></tr>
                                <tr><td>0</td><td>10</td><td>0 != 0</td><td>False</td><td>-</td><td>-</td><td>- (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>迴圈結束後，<code>sum</code> 的值為 10。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q26">下一題</button></div>
                </div>

                <div id="q26" class="quiz-card">
                    <h3>26. 執行下列程式碼後，請問輸出結果為？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int x=110, y=20;
  while(x>120){
    y=x-y;
    x++;
  }
  // printf("%3d%3d", x, y); // Original code has printf
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q26-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 111 90</div>
                        <div class="option" data-option="B">(B) 112 21</div>
                        <div class="option" data-option="C">(C) 110 90</div>
                        <div class="option" data-option="D">(D) 110 20</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>變數初始化：<code>x = 110</code>，<code>y = 20</code>。</p>
                        <p><code>while</code> 迴圈條件為 <code>x > 120</code>。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 x</th><th>迴圈開始前 y</th><th>條件檢查 (x > 120)</th><th>條件結果</th><th>動作</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>110</td><td>20</td><td>110 > 120</td><td>False</td><td>迴圈體不執行，直接跳過。</td></tr>
                            </tbody>
                        </table>
                        <p>由於初始時 <code>x</code> (110) 並不大於 120，所以 <code>while</code> 迴圈的條件一開始就為假。因此，迴圈體內的程式碼完全不會被執行。<code>x</code> 和 <code>y</code> 的值保持不變。</p>
                        <p>最終 <code>x</code> 的值為 110，<code>y</code> 的值為 20。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q27">下一題</button></div>
                </div>

                <div id="q27" class="quiz-card">
                    <h3>27. 執行下列程式碼後，請問輸出結果為？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int x=0, y=0;
  for(y=1; y&lt;=20; y++) {
    int z=y%5;
    if(z==0) x++;
  }
  // printf("%3d%3d",x,y); // Original code has printf
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q27-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 0 0</div>
                        <div class="option" data-option="B">(B) 4 21</div>
                        <div class="option" data-option="C">(C) 2 11</div>
                        <div class="option" data-option="D">(D) 3 11</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>變數 <code>x</code> 初始為 0，用於計數。變數 <code>y</code> 是 <code>for</code> 迴圈的計數器，從 1 迭代到 20。</p>
                        <p>在迴圈中，當 <code>y</code> 是 5 的倍數時 (即 <code>y % 5 == 0</code>)，<code>x</code> 會遞增。</p>
                        <p><code>y</code> 的值會是 5 的倍數的情況有：y=5, y=10, y=15, y=20。這四種情況下 <code>x</code> 會增加，所以迴圈結束後 <code>x</code> 的值為 4。</p>
                        <p><code>for</code> 迴圈的執行過程：</p>
                        <ul>
                            <li>初始化：<code>y = 1</code></li>
                            <li>條件檢查：<code>y <= 20</code></li>
                            <li>迴圈體執行</li>
                            <li>遞增：<code>y++</code></li>
                        </ul>
                        <p>當 <code>y</code> 為 20 時，條件 <code>20 <= 20</code> 為真，迴圈體執行 (<code>x</code> 可能增加)。之後 <code>y++</code> 使 <code>y</code> 變為 21。下一輪條件檢查 <code>21 <= 20</code> 為假，迴圈終止。</p>
                        <p>因此，在迴圈結束後，<code>x</code> 的值是 4，<code>y</code> 的值是 21。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q28">下一題</button></div>
                </div>

                <div id="q28" class="quiz-card">
                    <h3>28. 執行下列程式碼後，請問輸出結果為？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int a=5, b=2;
  if(a>b){
    a=a*b+2;
    b++;
  } else {
    a=a/2;
    b=b+4;
  }
  // printf("%3d%3d",a,b); // Original code has printf
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q28-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 8 2</div>
                        <div class="option" data-option="B">(B) 12 3</div>
                        <div class="option" data-option="C">(C) 2 6</div>
                        <div class="option" data-option="D">(D) 4 6</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路</h4>
                        <ol>
                            <li>變數初始化：<code>a = 5</code>，<code>b = 2</code>。</li>
                            <li><code>if</code> 條件判斷：<code>(a > b)</code> 即 <code>(5 > 2)</code>。此條件為真 (True)。</li>
                            <li>執行 <code>if</code> 為真時的區塊：
                                <ul>
                                    <li><code>a = a * b + 2;</code> => <code>a = 5 * 2 + 2 = 10 + 2 = 12</code>。現在 <code>a</code> 的值為 12。</li>
                                    <li><code>b++;</code> => <code>b = b + 1 = 2 + 1 = 3</code>。現在 <code>b</code> 的值為 3。</li>
                                </ul>
                            </li>
                            <li><code>else</code> 區塊不會被執行。</li>
                            <li>最終 <code>a</code> 的值為 12，<code>b</code> 的值為 3。</li>
                        </ol>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q29">下一題</button></div>
                </div>

                <div id="q29" class="quiz-card">
                    <h3>29. 執行下列程式碼後，請問輸出結果為？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int n=4, x=7, y=8;
  switch(n){
    case 1: x=n;break;
    case 2: y=y+4;
    case 3: x=n+5;break;
    case 4: x=x*4;
    default: y=y-4;
  }
  // printf("%2d%2d",x,y); // Original code has printf
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q29-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 28 4</div>
                        <div class="option" data-option="B">(B) 4 8</div>
                        <div class="option" data-option="C">(C) 9 12</div>
                        <div class="option" data-option="D">(D) 9 8</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路</h4>
                        <ol>
                            <li>變數初始化：<code>n = 4</code>, <code>x = 7</code>, <code>y = 8</code>。</li>
                            <li><code>switch(n)</code> 使用 <code>n</code> (值為 4) 進行判斷。</li>
                            <li><code>case 4:</code> 條件符合。
                                <ul>
                                    <li>執行 <code>x = x * 4;</code> => <code>x = 7 * 4 = 28</code>。現在 <code>x</code> 的值為 28。</li>
                                    <li>由於 <code>case 4:</code> 後面沒有 <code>break;</code> 語句，程式會繼續執行（fall-through）到下一個 <code>case</code> 或 <code>default</code> 標籤。</li>
                                </ul>
                            </li>
                            <li><code>default:</code> 程式執行到此。
                                <ul>
                                    <li>執行 <code>y = y - 4;</code> => <code>y = 8 - 4 = 4</code>。現在 <code>y</code> 的值為 4。</li>
                                </ul>
                            </li>
                            <li><code>switch</code> 結束。</li>
                            <li>最終 <code>x</code> 的值為 28，<code>y</code> 的值為 4。</li>
                        </ol>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q30">下一題</button></div>
                </div>

                <div id="q30" class="quiz-card">
                    <h3>30. 執行下列程式碼後，請問輸出結果為？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int x=30, y;
  if (x&lt;=5) {
    y=x*x;
    x+=5;
  } else {
    if (x&lt;10) {
      y=x-2;
    } else {
      if(x&lt;25) {
        y=x+10;
      } else {
        y=x/10;
      }
    }
    x++;
  }
  // printf("%3d%3d",y,x); // Original code has printf
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q30-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 28 31</div>
                        <div class="option" data-option="B">(B) 40 31</div>
                        <div class="option" data-option="C">(C) 3 31</div>
                        <div class="option" data-option="D">(D) 900 35</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路</h4>
                        <ol>
                            <li>變數初始化：<code>x = 30</code>。<code>y</code> 未明確初始化，但會在後續路徑中被賦值。</li>
                            <li>外層 <code>if</code> 條件：<code>(x <= 5)</code> 即 <code>(30 <= 5)</code>。此條件為假 (False)。</li>
                            <li>執行外層 <code>else</code> 區塊：
                                <ul>
                                    <li>內層第一個 <code>if</code> 條件：<code>(x < 10)</code> 即 <code>(30 < 10)</code>。此條件為假 (False)。</li>
                                    <li>執行內層第一個 <code>else</code> 區塊：
                                        <ul>
                                            <li>內層第二個 <code>if</code> 條件：<code>(x < 25)</code> 即 <code>(30 < 25)</code>。此條件為假 (False)。</li>
                                            <li>執行內層第二個 <code>else</code> 區塊：
                                                <ul>
                                                    <li><code>y = x / 10;</code> => <code>y = 30 / 10 = 3</code>。現在 <code>y</code> 的值為 3。</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>在第一個外層 <code>else</code> 區塊的末尾，執行 <code>x++;</code> => <code>x = 30 + 1 = 31</code>。現在 <code>x</code> 的值為 31。</li>
                                </ul>
                            </li>
                            <li>最終 <code>y</code> 的值為 3，<code>x</code> 的值為 31。</li>
                        </ol>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q31">下一題</button></div>
                </div>

                <div id="q31" class="quiz-card">
                    <h3>31. 當執行下列程式碼並輸入一串數值 5 2 -1 10 後，請問輸出結果為？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int x=3, y=6, z=0;
  // Assuming inputs 5, 2, -1, 10 for z in sequence for scanf
  do{
    // scanf("%d", &z); // Placeholder for actual input
    // For tracing, we'll manually set z based on the sequence
    // Iteration 1: z=5
    // Iteration 2: z=2
    // Iteration 3: z=-1
    // Iteration 4: z=10
    x = x+z+y;
    y++;
  } while(z&lt;10);
  y *= 2;
  // printf("%3d%3d%3d",z,x,y); // Original code has printf
  return 0;
}</code></pre>
                    <p><sub>(註：右側沙箱不支援 `scanf`，您可以參考範例程式碼中模擬輸入的方式進行測試。)</sub></p>
                    <button class="run-example-btn" data-code-id="q31-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 10 49 20</div>
                        <div class="option" data-option="B">(B) 10 48 20</div>
                        <div class="option" data-option="C">(C) 10 45 18</div>
                        <div class="option" data-option="D">(D) 10 3 6</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式使用 <code>do-while</code> 迴圈。變數 <code>x</code>, <code>y</code>, <code>z</code> 的初始值分別為 3, 6, 0。假設模擬的 <code>scanf</code> 輸入的 <code>z</code> 值序列為 5, 2, -1, 10。</p>
                        <table>
                            <thead>
                                <tr><th>迭代</th><th>開始前 x</th><th>開始前 y</th><th>模擬輸入 z (scanf)</th><th>執行 x=x+z+y</th><th>執行 y++</th><th>結束時 x</th><th>結束時 y</th><th>結束時 z</th><th>條件 (z&lt;10)</th><th>條件結果</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>-</td><td>3</td><td>6</td><td>0 (初始)</td><td>-</td><td>-</td><td>3</td><td>6</td><td>0</td><td>-</td><td>(進入迴圈)</td></tr>
                                <tr><td>1</td><td>3</td><td>6</td><td>5</td><td>x = 3+5+6 = 14</td><td>y = 7</td><td>14</td><td>7</td><td>5</td><td>5 &lt; 10</td><td>True</td></tr>
                                <tr><td>2</td><td>14</td><td>7</td><td>2</td><td>x = 14+2+7 = 23</td><td>y = 8</td><td>23</td><td>8</td><td>2</td><td>2 &lt; 10</td><td>True</td></tr>
                                <tr><td>3</td><td>23</td><td>8</td><td>-1</td><td>x = 23+(-1)+8 = 30</td><td>y = 9</td><td>30</td><td>9</td><td>-1</td><td>-1 &lt; 10</td><td>True</td></tr>
                                <tr><td>4</td><td>30</td><td>9</td><td>10</td><td>x = 30+10+9 = 49</td><td>y = 10</td><td>49</td><td>10</td><td>10</td><td>10 &lt; 10</td><td>False (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>迴圈終止後：</p>
                        <ul>
                            <li><code>z</code> 的最後讀取值是 10。</li>
                            <li><code>x</code> 的值是 49。</li>
                            <li><code>y</code> 的值是 10。</li>
                        </ul>
                        <p>接著執行 <code>y *= 2;</code> => <code>y = 10 * 2 = 20</code>。</p>
                        <p>最終 <code>z</code>=10, <code>x</code>=49, <code>y</code>=20。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q32">下一題</button></div>
                </div>

                <div id="q32" class="quiz-card">
                    <h3>32. 執行下列程式碼之後，請問最後 sum 的值多少？</h3>
                    <pre><code class="language-c">int x=0; int sum=0;
while(x &lt;= 200){
  sum += x;
  x += 2;
}
// printf("sum=%d", sum); // Original code has printf
</code></pre>
                    <button class="run-example-btn" data-code-id="q32-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 2000</div>
                        <div class="option" data-option="B">(B) 2525</div>
                        <div class="option" data-option="C">(C) 5050</div>
                        <div class="option" data-option="D">(D) 10100</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式碼使用 <code>while</code> 迴圈計算從 0 開始，每次遞增 2（即所有偶數），直到 <code>x</code> 超過 200 時的總和。變數 <code>sum</code> 用於累加，<code>x</code> 從 0 開始。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 x</th><th>條件 (x &lt;= 200)</th><th>條件結果</th><th>執行 sum += x (目前 sum)</th><th>執行 x += 2</th><th>迴圈結束後 x</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>0 (初始)</td><td>0 &lt;= 200</td><td>True</td><td>sum = 0 + 0 = 0</td><td>x = 0 + 2 = 2</td><td>2</td></tr>
                                <tr><td>2</td><td>2 &lt;= 200</td><td>True</td><td>sum = 0 + 2 = 2</td><td>x = 2 + 2 = 4</td><td>4</td></tr>
                                <tr><td>4</td><td>4 &lt;= 200</td><td>True</td><td>sum = 2 + 4 = 6</td><td>x = 4 + 2 = 6</td><td>6</td></tr>
                                <tr><td colspan="6" style="text-align:center;">... 繼續累加 ...</td></tr>
                                <tr><td>198</td><td>198 &lt;= 200</td><td>True</td><td>sum = (sum of 0..196) + 198 = 9900</td><td>x = 198 + 2 = 200</td><td>200</td></tr>
                                <tr><td>200</td><td>200 &lt;= 200</td><td>True</td><td>sum = 9900 + 200 = 10100</td><td>x = 200 + 2 = 202</td><td>202</td></tr>
                                <tr><td>202</td><td>202 &lt;= 200</td><td>False</td><td>- (不執行)</td><td>202 (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>這是一個等差數列求和：0 + 2 + 4 + ... + 200。
                        首項 a1 = 0，末項 an = 200，公差 d = 2。
                        項數 N = (an - a1)/d + 1 = (200 - 0)/2 + 1 = 100 + 1 = 101 項。
                        總和 S = N * (a1 + an) / 2 = 101 * (0 + 200) / 2 = 101 * 200 / 2 = 101 * 100 = 10100。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q33">下一題</button></div>
                </div>

                <div id="q33" class="quiz-card">
                    <h3>33. 在下列的程式片段中，請問執行結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int a=1;
  while(++a&lt;5){
    printf("%d ", a);
  }
  // printf("\n"); // For clarity if run
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q33-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 1 2 3 4</div>
                        <div class="option" data-option="B">(B) 1 2 3 4 5</div>
                        <div class="option" data-option="C">(C) 2 3 4</div>
                        <div class="option" data-option="D">(D) 2 3 4 5</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>變數 <code>a</code> 初始值為 1。<code>while</code> 迴圈的條件是 <code>++a &lt; 5</code>，這裡使用了前置遞增運算子 (pre-increment)。這表示 <code>a</code> 會先加 1，然後才用新的值進行條件比較。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 a</th><th>執行 ++a (a 變為)</th><th>條件檢查 (新 a &lt; 5)</th><th>條件結果</th><th>動作 (printf a)</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>1 (初始)</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
                                <tr><td>1</td><td>a = 2</td><td>2 &lt; 5</td><td>True</td><td>印出 "2 "</td></tr>
                                <tr><td>2</td><td>a = 3</td><td>3 &lt; 5</td><td>True</td><td>印出 "3 "</td></tr>
                                <tr><td>3</td><td>a = 4</td><td>4 &lt; 5</td><td>True</td><td>印出 "4 "</td></tr>
                                <tr><td>4</td><td>a = 5</td><td>5 &lt; 5</td><td>False</td><td>迴圈終止</td></tr>
                            </tbody>
                        </table>
                        <p>最終輸出為 "2 3 4 "。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q34">下一題</button></div>
                </div>

                <div id="q34" class="quiz-card">
                    <h3>34. 在下列的程式片段中，請問執行結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int a=1;
  while(a++&lt;5){
    printf("%d ", a);
  }
  // printf("\n"); // For clarity if run
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q34-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) .1 2 3 4</div>
                        <div class="option" data-option="B">(B) .1 2 3 4 5</div>
                        <div class="option" data-option="C">(C) .2 3 4</div>
                        <div class="option" data-option="D">(D) .2 3 4 5</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>變數 <code>a</code> 初始值為 1。<code>while</code> 迴圈的條件是 <code>a++ &lt; 5</code>，這裡使用了後置遞增運算子 (post-increment)。這表示先使用 <code>a</code> 的當前值進行條件比較，然後才將 <code>a</code> 的值加 1。迴圈體內印出的是遞增後的 <code>a</code>。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 a</th><th>條件檢查 (舊 a &lt; 5)</th><th>條件結果</th><th>執行 a++ (a 變為)</th><th>動作 (printf 新 a)</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>1 (初始)</td><td>1 &lt; 5</td><td>True</td><td>a = 2</td><td>印出 "2 "</td></tr>
                                <tr><td>2</td><td>2 &lt; 5</td><td>True</td><td>a = 3</td><td>印出 "3 "</td></tr>
                                <tr><td>3</td><td>3 &lt; 5</td><td>True</td><td>a = 4</td><td>印出 "4 "</td></tr>
                                <tr><td>4</td><td>4 &lt; 5</td><td>True</td><td>a = 5</td><td>印出 "5 "</td></tr>
                                <tr><td>5</td><td>5 &lt; 5</td><td>False</td><td>a = 6 (仍執行遞增)</td><td>迴圈終止</td></tr>
                            </tbody>
                        </table>
                        <p>最終輸出為 "2 3 4 5 "。選項中的點 `.` 應為題目來源的筆誤。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q35">下一題</button></div>
                </div>

                <div id="q35" class="quiz-card">
                    <h3>35. 在下列的程式片段中，請問執行結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int a=1;
  do{
    printf("%d ", a);
  }while(++a&lt;5);
  // printf("\n"); // For clarity if run
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q35-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) . 1 2 3 4</div>
                        <div class="option" data-option="B">(B) . 1 2 3 4 5</div>
                        <div class="option" data-option="C">(C) . 2 3 4</div>
                        <div class="option" data-option="D">(D) . 2 3 4 5</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>變數 <code>a</code> 初始值為 1。此為 <code>do-while</code> 迴圈，迴圈體至少執行一次。條件是 <code>++a &lt; 5</code> (前置遞增)。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 a</th><th>動作 (printf a)</th><th>執行 ++a (a 變為)</th><th>條件檢查 (新 a &lt; 5)</th><th>條件結果</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>1 (初始)</td><td>印出 "1 "</td><td>a = 2</td><td>2 &lt; 5</td><td>True</td></tr>
                                <tr><td>2</td><td>印出 "2 "</td><td>a = 3</td><td>3 &lt; 5</td><td>True</td></tr>
                                <tr><td>3</td><td>印出 "3 "</td><td>a = 4</td><td>4 &lt; 5</td><td>True</td></tr>
                                <tr><td>4</td><td>印出 "4 "</td><td>a = 5</td><td>5 &lt; 5</td><td>False (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>最終輸出為 "1 2 3 4 "。選項中的點 `.` 應為題目來源的筆誤。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q36">下一題</button></div>
                </div>

                <div id="q36" class="quiz-card">
                    <h3>36. 在下列的程式片段中，請問執行結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int a=1;
  do{
    printf("%d ", a);
  }while(a++&lt;5);
  // printf("\n"); // For clarity if run
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q36-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) . 1 2 3 4</div>
                        <div class="option" data-option="B">(B) . 1 2 3 4 5</div>
                        <div class="option" data-option="C">(C) . 2 3 4</div>
                        <div class="option" data-option="D">(D) . 2 3 4 5</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>變數 <code>a</code> 初始值為 1。此為 <code>do-while</code> 迴圈，迴圈體至少執行一次。條件是 <code>a++ &lt; 5</code> (後置遞增)。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 a</th><th>動作 (printf a)</th><th>條件檢查 (使用舊 a &lt; 5)</th><th>條件結果</th><th>執行 a++ (a 變為)</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>1 (初始)</td><td>印出 "1 "</td><td>1 &lt; 5</td><td>True</td><td>a = 2</td></tr>
                                <tr><td>2</td><td>印出 "2 "</td><td>2 &lt; 5</td><td>True</td><td>a = 3</td></tr>
                                <tr><td>3</td><td>印出 "3 "</td><td>3 &lt; 5</td><td>True</td><td>a = 4</td></tr>
                                <tr><td>4</td><td>印出 "4 "</td><td>4 &lt; 5</td><td>True</td><td>a = 5</td></tr>
                                <tr><td>5</td><td>印出 "5 "</td><td>5 &lt; 5</td><td>False</td><td>a = 6 (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>最終輸出為 "1 2 3 4 5 "。選項中的點 `.` 應為題目來源的筆誤。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q37">下一題</button></div>
                </div>

                <div id="q37" class="quiz-card">
                    <h3>37. 在下列的程式片段中，是利用輾轉相除法來求得 m 與 n 的最大公因數，請問迴圈內的敘述應該為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int m,n,r;
  // Assume m and n are read via scanf, e.g., m=48, n=18
  // m = 48; n = 18; // For tracing example
  r = m % n;
  while (r != 0){
    // MISSING LOGIC
  }
  // printf("GCD is %d\n", n);
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q37-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) <pre><code class='language-markup'>r = m % n;
m = n;
n = r;</code></pre></div>
                        <div class="option" data-option="B">(B) <pre><code class='language-markup'>r = m % n;
n = r;
m = n;</code></pre></div>
                        <div class="option" data-option="C">(C) <pre><code class='language-markup'>n = r;
m = n;
r = m % n;</code></pre></div>
                        <div class="option" data-option="D">(D) <pre><code class='language-markup'>m = n;
n = r;
r = m % n;</code></pre></div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：輾轉相除法 (Euclidean Algorithm)</h4>
                        <p>輾轉相除法的核心思想是：兩個整數的最大公因數 (GCD) 等於其中較小數與兩數相除餘數的 GCD。重複此過程直到餘數為 0，此時的除數即為原始兩數的 GCD。</p>
                        <p>程式碼中，<code>r = m % n;</code> 在迴圈外計算了第一次的餘數。<code>while (r != 0)</code> 條件表示只要餘數不為零，就繼續運算。</p>
                        <p>在迴圈內部，需要進行以下更新：</p>
                        <ol>
                            <li>原來的除數 <code>n</code> 變成新的被除數 (新的 <code>m</code>)。</li>
                            <li>原來的餘數 <code>r</code> (上一輪 <code>m % n</code> 的結果) 變成新的除數 (新的 <code>n</code>)。</li>
                            <li>然後計算新的餘數 <code>r</code> (用新的 <code>m</code> 和 <code>n</code>)，用於下一次迴圈條件的判斷。</li>
                        </ol>
                        <p>對照選項，選項 (D) <code>m = n; n = r; r = m % n;</code> 完全符合這個迭代步驟。</p>
                        <p><b>追蹤範例 (m=48, n=18):</b></p>
                        <p>初始： <code>m = 48</code>, <code>n = 18</code>. 迴圈外計算 <code>r = 48 % 18 = 12</code>.</p>
                        <table>
                            <thead><tr><th>迴圈開始前 m</th><th>迴圈開始前 n</th><th>迴圈開始前 r</th><th>條件 (r != 0)</th><th>執行 (D)</th><th>結束時 m</th><th>結束時 n</th><th>結束時 r</th></tr></thead>
                            <tbody>
                                <tr><td>48</td><td>18</td><td>12</td><td>12 != 0 (True)</td><td>m=18; n=12; r=18%12=6;</td><td>18</td><td>12</td><td>6</td></tr>
                                <tr><td>18</td><td>12</td><td>6</td><td>6 != 0 (True)</td><td>m=12; n=6; r=12%6=0;</td><td>12</td><td>6</td><td>0</td></tr>
                                <tr><td>12</td><td>6</td><td>0</td><td>0 != 0 (False)</td><td>迴圈終止</td><td>12</td><td>6</td><td>0</td></tr>
                            </tbody>
                        </table>
                        <p>迴圈終止後，<code>n</code> 的值為 6，這就是 48 和 18 的最大公因數。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q38">下一題</button></div>
                </div>

                <div id="q38" class="quiz-card">
                    <h3>38. 請問下列程式片段執行後，會印出什麼？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int x=2, y=0;
  for (y=1; y&lt;=30; y++){
    int z=y%6;
    if (z==0) x+=2;
  }
  // printf("%3d%3d", x, y); // Original code has printf
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q38-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 5 31</div>
                        <div class="option" data-option="B">(B) 15 31</div>
                        <div class="option" data-option="C">(C) 10 31</div>
                        <div class="option" data-option="D">(D) 12 31</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>變數 <code>x</code> 初始為 2。<code>for</code> 迴圈使變數 <code>y</code> 從 1 迭代到 30。在每次迭代中，如果 <code>y</code> 是 6 的倍數 (即 <code>y % 6 == 0</code>)，則 <code>x</code> 的值增加 2。</p>
                        <p><code>y</code> 是 6 的倍數的情況 (在 1 到 30 之間)：6, 12, 18, 24, 30。共有 5 次。</p>
                        <p>每次符合條件時 <code>x</code> 增加 2，所以 <code>x</code> 總共增加 <code>5 * 2 = 10</code>。
                        因此，<code>x</code> 的最終值為 <code>2 (初始值) + 10 = 12</code>。</p>
                        <p><code>for</code> 迴圈的執行：<code>y</code> 從 1 開始，條件是 <code>y <= 30</code>。當 <code>y</code> 為 30 時，迴圈體執行，然後 <code>y++</code> 使 <code>y</code> 變為 31。下一輪條件檢查 <code>31 <= 30</code> 為假，迴圈終止。</p>
                        <p>因此，在迴圈結束後，<code>x</code> 的值是 12，<code>y</code> 的值是 31。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q39">下一題</button></div>
                </div>

                <div id="q39" class="quiz-card">
                    <h3>39. 請問下列程式片段執行後，輸出的第 12 個數值是？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
#include &lt;stdbool.h&gt;
int main(){
  int p,d;
  bool flag;
  int prime_count = 0;
  int twelfth_prime_val = 0; // To store the 12th prime

  for (p=2; p&lt;=50; ++p){
    flag = true;
    for (d=2; d&lt;p; ++d) {
      if (p%d == 0) {
        flag=false;
        break;
      }
    }
    if (flag) {
      // printf("%i ", p); // Original code implies printing
      prime_count++;
      if (prime_count == 12) {
        twelfth_prime_val = p;
        // No break here, so it finds all primes up to 50
      }
    }
  }
  // The question asks for the 12th value *outputted*.
  // If twelfth_prime_val was printed, that would be it.
  // Assuming the question implies the 12th prime in the sequence generated.
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q39-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 31</div>
                        <div class="option" data-option="B">(B) 37</div>
                        <div class="option" data-option="C">(C) 41</div>
                        <div class="option" data-option="D">(D) 43</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路</h4>
                        <p>此程式碼片段的目的是找出並（概念上，如果 <code>printf</code> 被啟用）印出從 2 到 50 之間的所有質數。題目問的是輸出的第 12 個數值。</p>
                        <p>質數是只能被 1 和它本身整除的大於 1 的自然數。</p>
                        <p>外層迴圈 <code>for (p=2; p&lt;=50; ++p)</code> 迭代可能的質數候選者 <code>p</code>。</p>
                        <p>內層迴圈 <code>for (d=2; d&lt;p; ++d)</code> 檢查 <code>p</code> 是否能被 <code>d</code> (從 2 到 <code>p-1</code>) 整除。如果 <code>p % d == 0</code>，則 <code>p</code> 不是質數，<code>flag</code> 設為 <code>false</code>，並透過 <code>break</code> 提早跳出內層迴圈。</p>
                        <p>如果內層迴圈完成後 <code>flag</code> 仍為 <code>true</code>，則 <code>p</code> 是質數。程式會增加 <code>prime_count</code>。如果 <code>prime_count</code> 達到 12，則將該質數存入 <code>twelfth_prime_val</code>。</p>
                        <p>我們來列出 2 到 50 之間的質數，並計數：</p>
                        <ol>
                            <li>p=2, flag=true. prime_count=1.</li>
                            <li>p=3, flag=true. prime_count=2.</li>
                            <li>p=5, flag=true. prime_count=3.</li>
                            <li>p=7, flag=true. prime_count=4.</li>
                            <li>p=11, flag=true. prime_count=5.</li>
                            <li>p=13, flag=true. prime_count=6.</li>
                            <li>p=17, flag=true. prime_count=7.</li>
                            <li>p=19, flag=true. prime_count=8.</li>
                            <li>p=23, flag=true. prime_count=9.</li>
                            <li>p=29, flag=true. prime_count=10.</li>
                            <li>p=31, flag=true. prime_count=11.</li>
                            <li><b>p=37, flag=true. prime_count=12.</b> (twelfth_prime_val = 37)</li>
                            <li>p=41, flag=true. prime_count=13.</li>
                            <li>p=43, flag=true. prime_count=14.</li>
                            <li>p=47, flag=true. prime_count=15.</li>
                        </ol>
                        <p>因此，程式找到的第 12 個質數是 37。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q40">下一題</button></div>
                </div>

                <div id="q40" class="quiz-card">
                    <h3>40. 下列 cIc++程式片段之敘述，何者正確？</h3> <!-- Assuming cIc++ means C/C++ -->
                    <pre><code class="language-c">// Assuming C context with stdio.h for I/O
#include &lt;stdio.h&gt;
int main() {
  int a,b,c;
  // Original problem implies reading a and b, e.g. using cin or scanf
  // For C, this would be: scanf("%d %d", &a, &b);
  // Let's assume a=5, b=10 for demonstration.
  a = 5;
  b = 10;

  c=a; // c is now 5
  if (b>c) { // (10 > 5) is true
     c=b; // c becomes 10
  }
  // printf("the output is:%d\n", c); // c is 10 (the maximum of a and b)
  return 0;
}
</code></pre>
                    <button class="run-example-btn" data-code-id="q40-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 找出輸入數值最小值</div>
                        <div class="option" data-option="B">(B) 找出輸入數值最大值</div>
                        <div class="option" data-option="C">(C) 輸入三個變數</div>
                        <div class="option" data-option="D">(D) 輸出結果為 the output is.c</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路</h4>
                        <p>此程式碼片段的目的是找出兩個（概念上）輸入的數值 <code>a</code> 和 <code>b</code> 中的最大值。</p>
                        <ol>
                            <li>宣告三個整數變數 <code>a</code>, <code>b</code>, <code>c</code>。</li>
                            <li>（假設）程式會讀取兩個整數值到 <code>a</code> 和 <code>b</code>。</li>
                            <li>將 <code>a</code> 的值賦給 <code>c</code>。所以 <code>c</code> 的初始值與 <code>a</code> 相同。</li>
                            <li>進行條件判斷 <code>if (b > c)</code>：
                                <ul>
                                    <li>如果 <code>b</code> 的值大於 <code>c</code>（也就是大於 <code>a</code> 的初始值），則將 <code>b</code> 的值賦給 <code>c</code>。此時 <code>c</code> 會儲存 <code>b</code> 的值。</li>
                                    <li>如果 <code>b</code> 的值不大於 <code>c</code>，則 <code>c</code> 的值（即 <code>a</code> 的值）保持不變。</li>
                                </ul>
                            </li>
                            <li>最終，<code>c</code> 會儲存 <code>a</code> 和 <code>b</code> 中較大的那個值。</li>
                        </ol>
                        <p>因此，此程式片段的功能是找出輸入的兩個數值中的最大值。</p>
                        <ul>
                            <li>(A) 不正確，程式是找最大值。</li>
                            <li>(C) 不正確，程式主要處理兩個輸入變數 <code>a</code> 和 <code>b</code>；<code>c</code> 用於儲存比較後的結果。</li>
                            <li>(D) 不正確，"the output is.c" 是一個檔案名稱的格式，不是 C 語言程式的輸出結果。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q41">下一題</button></div>
                </div>

                <div id="q41" class="quiz-card">
                    <h3>41. 在下列的程式片段中，中間的 13~16 行的 if 該如何寫，可以將 x， y， z 三個數由小到大排序？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int x, y, z;
  int temp;
  // Assume x, y, z are initialized, e.g., x=7, y=2, z=5 for testing
  // scanf("%d%d%d", &x, &y, &z);

  // Step 1: Ensure x &lt;= y
  if(x>y){
    temp = x; x = y; y = temp;
  }
  // At this point, x holds the smaller of original x and y.
  // y holds the larger of original x and y.

  // Step 2: (Lines 13-16) - The missing if block
  // This step should place z correctly relative to the current y.
  // We want to ensure y &lt;= z after this step.
  // Option (B): if (y > z) { temp = y; y = z; z = temp; }
  // This swaps y and z if y is larger, making y the smaller of (current y, current z)
  // and z the larger.

  // Step 3: Ensure x &lt;= y again
  // After step 2, z might have been swapped into y. This new y could be smaller than x.
  if (x>y){
    temp = x; x = y; y = temp;
  }
  // printf("%d %d %d\n", x, y, z);
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q41-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) <pre><code class='language-markup'>if (x > z){
temp = x; x = z;
z = temp;
}</code></pre></div>
                        <div class="option" data-option="B">(B) <pre><code class='language-markup'>if (y > z){
temp = y; y = z;
z = temp;
}</code></pre></div>
                        <div class="option" data-option="C">(C) <pre><code class='language-markup'>if (x > y){
temp = x; x = y;
y = temp;
}</code></pre></div>
                        <div class="option" data-option="D">(D) <pre><code class='language-markup'>if (z > x){
temp = z; z = x;
x = temp;
}</code></pre></div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：三數排序 (簡易氣泡排序法變形)</h4>
                        <p>此程式的目標是透過一系列的比較和交換，將三個整數 <code>x</code>, <code>y</code>, <code>z</code> 由小到大排序。</p>
                        <ol>
                            <li><b>第一個 <code>if(x>y)</code> 區塊 (行 7-10):</b>
                                <p>此區塊確保執行後 <code>x <= y</code>。如果原始 <code>x</code> 大於 <code>y</code>，則交換它們。</p>
                                <p><i>範例 (x=7, y=2, z=5):</i> <code>7 > 2</code> 為真，交換後 <code>x=2, y=7, z=5</code>。</p>
                            </li>
                            <li><b>中間遺失的 <code>if</code> 區塊 (行 13-16) - 選項 (B) <code>if (y > z) { temp = y; y = z; z = temp; }</code>:</b>
                                <p>此時我們有 <code>x <= y</code>。這個區塊的目的是比較當前的 <code>y</code> 和 <code>z</code>。如果 <code>y > z</code>，則交換它們，確保執行後 <code>y <= z</code>。</p>
                                <p><i>範例 (續上 x=2, y=7, z=5):</i> <code>y > z</code> (即 <code>7 > 5</code>) 為真。交換 <code>y</code> 和 <code>z</code>。
                                <br><code>temp = 7; y = 5; z = 7;</code>
                                <br>執行後狀態：<code>x=2, y=5, z=7</code>。</p>
                            </li>
                            <li><b>最後一個 <code>if(x>y)</code> 區塊 (行 18-22):</b>
                                <p>在前一步中，如果 <code>z</code> 原本比 <code>y</code> 小，它們會被交換，使得原來的 <code>z</code> 現在位於 <code>y</code> 的位置。這個新的 <code>y</code> 值（即原來的 <code>z</code>）有可能比 <code>x</code> 還要小。因此，需要再次比較 <code>x</code> 和 <code>y</code>。如果 <code>x > y</code>，則交換它們，以確保最小的值最終在 <code>x</code> 中。</p>
                                <p><i>範例 (續上 x=2, y=5, z=7):</i> <code>x > y</code> (即 <code>2 > 5</code>) 為假。不執行交換。</p>
                                <p>最終狀態：<code>x=2, y=5, z=7</code>，已排序。</p>
                            </li>
                        </ol>
                        <p>這個三步驟的過程能有效地將三個數排序。選項 (B) 是完成此排序邏輯的正確中間步驟。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q42">下一題</button></div>
                </div>

                <div id="q42" class="quiz-card">
                    <h3>42. 在下面的程式片段中 8~10 行，while 迴圈該如何撰寫，可以計算輸入的整數 n 每個位數的總和，例如輸入 1234，輸出 10。</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int n;
  int sum = 0;
  // scanf("%d", &n); // Assume n is initialized, e.g., n=1234

  // while( /* MISSING CONDITION AND BODY */ ){
  //
  // }

  // printf("%d\n", sum);
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q42-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) <pre><code class='language-markup'>while(n != 0){
n /= 10;
sum += n%10;
}</code></pre></div>
                        <div class="option" data-option="B">(B) <pre><code class='language-markup'>while(n/10 != 0){
sum += n%10;
n /= 10;
}</code></pre></div>
                        <div class="option" data-option="C">(C) <pre><code class='language-markup'>while(n != 0){
sum = n%10; // Error: sum is overwritten
n /= 10;
}</code></pre></div>
                        <div class="option" data-option="D">(D) <pre><code class='language-markup'>while(n != 0){
sum += n%10;
n /= 10;
}</code></pre></div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：計算各位數字之和</h4>
                        <p>要計算一個整數 <code>n</code> 的各位數字之和，我們通常使用取模 (<code>%</code>) 和整除 (<code>/</code>) 運算：</p>
                        <ol>
                            <li>取得 <code>n</code> 的最右邊（個位）數字：<code>digit = n % 10</code>。</li>
                            <li>將此數字加到總和 <code>sum</code>：<code>sum = sum + digit</code>。</li>
                            <li>移除 <code>n</code> 的最右邊數字：<code>n = n / 10</code> (整數除法)。</li>
                            <li>重複以上步驟，直到 <code>n</code> 變為 0 (表示所有位數都已處理)。</li>
                        </ol>
                        <p>分析選項：</p>
                        <ul>
                            <li><b>(A)</b> <code>n /= 10; sum += n%10;</code> - 錯誤。它先移除了 <code>n</code> 的個位數 (例如 1234 變成 123)，然後才用新的 <code>n</code> (123) 去取模 (123%10 = 3)，這會導致原始的個位數 (4) 被遺漏。</li>
                            <li><b>(B)</b> <code>while(n/10 != 0)</code> - 錯誤。如果 <code>n</code> 是個位數 (例如 <code>n=7</code>)，<code>n/10</code> 會是 0，迴圈條件 <code>0 != 0</code> 為假，迴圈一次都不會執行，導致這個個位數沒有被加總。它會在處理到只剩最高位數時提前終止。</li>
                            <li><b>(C)</b> <code>sum = n%10;</code> - 錯誤。這會用每個個位數去覆寫 <code>sum</code> 的值，而不是累加。最終 <code>sum</code> 只會是原始數字的最高位數 (因為迴圈最後一次迭代時 <code>n</code> 是最高位數)。</li>
                            <li><b>(D)</b> <code>while(n != 0){ sum += n%10; n /= 10; }</code> - 正確。
                                <ul>
                                    <li>迴圈條件 <code>n != 0</code> 確保所有位數都被處理，直到 <code>n</code> 變成0。</li>
                                    <li><code>sum += n%10;</code> 正確地將當前 <code>n</code> 的個位數累加到 <code>sum</code>。</li>
                                    <li><code>n /= 10;</code> 正確地移除 <code>n</code> 的個位數，為下一輪迭代做準備。</li>
                                </ul>
                            </li>
                        </ul>
                        <p><b>以 n=1234 追蹤選項 (D)：</b></p>
                        <table>
                            <thead><tr><th>迴圈開始前 n</th><th>迴圈開始前 sum</th><th>條件 (n != 0)</th><th>n % 10</th><th>sum += (n%10) (sum變為)</th><th>n /= 10 (n變為)</th></tr></thead>
                            <tbody>
                                <tr><td>1234</td><td>0</td><td>1234 != 0 (True)</td><td>4</td><td>0 + 4 = 4</td><td>123</td></tr>
                                <tr><td>123</td><td>4</td><td>123 != 0 (True)</td><td>3</td><td>4 + 3 = 7</td><td>12</td></tr>
                                <tr><td>12</td><td>7</td><td>12 != 0 (True)</td><td>2</td><td>7 + 2 = 9</td><td>1</td></tr>
                                <tr><td>1</td><td>9</td><td>1 != 0 (True)</td><td>1</td><td>9 + 1 = 10</td><td>0</td></tr>
                                <tr><td>0</td><td>10</td><td>0 != 0 (False)</td><td colspan="3">- (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q43">下一題</button></div>
                </div>

                <div id="q43" class="quiz-card">
                    <h3>43. 有關下面 c 程式片段之描述，int k=10， while (k==0) k=k-1， 何者正確？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 迴圈內程式，被執行 1 次</div>
                        <div class="option" data-option="B">(B) 迴圈內程式，會被一直執行</div>
                        <div class="option" data-option="C">(C) 迴圈內程式，1 次也不會被執行</div>
                        <div class="option" data-option="D">(D) 迴圈內程式，被執行 10 次</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路</h4>
                        <ol>
                            <li>變數初始化：<code>int k=10;</code>。</li>
                            <li><code>while</code> 迴圈條件檢查：<code>(k==0)</code>。
                                <ul>
                                    <li>將 <code>k</code> 的當前值 (10) 與 0 比較：<code>(10 == 0)</code>。</li>
                                    <li>此條件為假 (False)，因為 10 不等於 0。</li>
                                </ul>
                            </li>
                            <li>由於迴圈條件一開始就為假，迴圈體 <code>k=k-1;</code> 一次也不會被執行。</li>
                        </ol>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q44">下一題</button></div>
                </div>

                <div id="q44" class="quiz-card">
                    <h3>44. 請問下面 c 程式中，printf("\n")共被執灖幾次？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main() {
  for (int i=1; i&lt;=4; i++){
    for (int j=1; j&lt;5; j++)
      printf("*");
    printf("\n");
  }
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q44-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 4</div>
                        <div class="option" data-option="B">(B) 5</div>
                        <div class="option" data-option="C">(C) 8</div>
                        <div class="option" data-option="D">(D) 16</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式使用巢狀 <code>for</code> 迴圈。我們關心的是外層迴圈中 <code>printf("\n");</code> 語句的執行次數。</p>
                        <p>外層迴圈：<code>for (int i=1; i&lt;=4; i++)</code></p>
                        <ul>
                            <li>此迴圈會執行，當 <code>i</code> 的值為 1, 2, 3, 4。共 4 次迭代。</li>
                        </ul>
                        <p>內層迴圈：<code>for (int j=1; j&lt;5; j++)</code></p>
                        <ul>
                            <li>此迴圈會執行，當 <code>j</code> 的值為 1, 2, 3, 4。對於外層迴圈的每一次迭代，內層迴圈都會完整執行 4 次，印出 4 個星號。</li>
                        </ul>
                        <p><code>printf("\n");</code> 語句位於外層迴圈之內，但在內層迴圈之外。這意味著，每當內層迴圈（印星號的迴圈）執行完畢後，就會執行一次換行操作。</p>
                        <p>追蹤外層迴圈的 <code>i</code> 和 <code>printf("\n")</code> 的執行：</p>
                        <table>
                            <thead><tr><th>i 值</th><th>內層迴圈執行</th><th>printf("\n") 執行?</th><th>累計換行次數</th></tr></thead>
                            <tbody>
                                <tr><td>1</td><td>執行 (印出 ****)</td><td>是</td><td>1</td></tr>
                                <tr><td>2</td><td>執行 (印出 ****)</td><td>是</td><td>2</td></tr>
                                <tr><td>3</td><td>執行 (印出 ****)</td><td>是</td><td>3</td></tr>
                                <tr><td>4</td><td>執行 (印出 ****)</td><td>是</td><td>4</td></tr>
                                <tr><td>5 (迴圈終止)</td><td>-</td><td>-</td><td>4</td></tr>
                            </tbody>
                        </table>
                        <p>因此，<code>printf("\n");</code> 共被執行 4 次。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q45">下一題</button></div>
                </div>

                <div id="q45" class="quiz-card">
                    <h3>45. 請問下列程式執行後，輸出結果為？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main() {
  float salary = 400.0f; // Added 'f' for float literal clarity
  if (salary > 400.0f){
    float bonus = 10.0f;
    salary += bonus;
  } else {
    salary += salary * 0.2f;
  }
  printf("%.2f", salary);
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q45-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 410.000000</div>
                        <div class="option" data-option="B">(B) 410.00</div>
                        <div class="option" data-option="C">(C) 480.00</div>
                        <div class="option" data-option="D">(D) 480.00000</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路</h4>
                        <ol>
                            <li>變數初始化：<code>float salary = 400.0f;</code></li>
                            <li><code>if</code> 條件判斷：<code>(salary > 400.0f)</code> 即 <code>(400.0f > 400.0f)</code>。此條件為假 (False)，因為 400.0f 並不嚴格大於 400.0f。</li>
                            <li>執行 <code>else</code> 區塊：
                                <ul>
                                    <li><code>salary += salary * 0.2f;</code></li>
                                    <li>計算 <code>salary * 0.2f</code> => <code>400.0f * 0.2f = 80.0f</code>。</li>
                                    <li>計算 <code>salary = salary + 80.0f</code> => <code>salary = 400.0f + 80.0f = 480.0f</code>。</li>
                                </ul>
                            </li>
                            <li>程式最後執行 <code>printf("%.2f", salary);</code>。
                                <ul>
                                    <li><code>%.2f</code> 格式指定字串表示以浮點數形式輸出，並保留小數點後兩位。</li>
                                    <li>因此，輸出 480.00。</li>
                                </ul>
                            </li>
                        </ol>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q46">下一題</button></div>
                </div>

                <div id="q46" class="quiz-card">
                    <h3>46. 請問以下程式，所輸出的第 3 個結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main() {
  int n=4, a=1;
  for (int i=1; i&lt;=n; i++){
    for (int c=1; c&lt;=i; c++){
      printf("%d", a);
      a++;
    }
    printf("\n"); // "結果" 指的是每一行輸出的內容
  }
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q46-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 456</div>
                        <div class="option" data-option="B">(B) 23</div>
                        <div class="option" data-option="C">(C) 1</div>
                        <div class="option" data-option="D">(D) 78910</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式使用巢狀 <code>for</code> 迴圈印出一種數字圖案。變數 <code>a</code> 從 1 開始，並在每次印出後遞增。外層迴圈控制行數 (由 <code>i</code> 控制)，內層迴圈控制每行印出的數字個數 (由 <code>c</code> 控制，最多印 <code>i</code> 個)。</p>
                        <p>"結果" 指的是每一行 <code>printf("\n")</code> 之前所印出的數字序列。</p>
                        <table>
                            <thead><tr><th>外層 i</th><th>內層 c 範圍</th><th>印出的數字 (a 的值)</th><th>該行輸出 (結果)</th><th>執行後 a</th></tr></thead>
                            <tbody>
                                <tr><td>1</td><td>c=1 to 1</td><td>1</td><td>1</td><td>2</td></tr>
                                <tr><td>2</td><td>c=1 to 2</td><td>2, 3</td><td>23</td><td>4</td></tr>
                                <tr><td><b>3</b></td><td>c=1 to 3</td><td><b>4, 5, 6</b></td><td><b>456</b></td><td>7</td></tr>
                                <tr><td>4</td><td>c=1 to 4</td><td>7, 8, 9, 10</td><td>78910</td><td>11</td></tr>
                            </tbody>
                        </table>
                        <p>第 1 個結果 (i=1): "1"</p>
                        <p>第 2 個結果 (i=2): "23"</p>
                        <p><b>第 3 個結果 (i=3): "456"</b></p>
                        <p>第 4 個結果 (i=4): "78910"</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q47">下一題</button></div>
                </div>

                <div id="q47" class="quiz-card">
                    <h3>47. 根據右側之流程圖分析，當程式執行到最後一個列印方塊時，下列敘述何者正確？</h3>
                    <p><sub>(由於題目未提供流程圖，此題的解釋基於常見的程式邏輯推斷及所給答案。假設流程圖描述了一個從0到9累加的過程，結果存於K。)</sub></p>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 程式結束時，K = 45</div>
                        <div class="option" data-option="B">(B) 程式結束時，Q = 11</div>
                        <div class="option" data-option="C">(C) 這是一個迴圈程式，迴圈內程式總共執行 9 次</div>
                        <div class="option" data-option="D">(D) 程式結束時，Y = 10</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路 (基於假設與答案)</h4>
                        <p>由於沒有提供實際的流程圖，我們只能根據選項和常見的程式模式來推斷。如果答案 (A) "程式結束時，K = 45" 是正確的，一個非常常見的能產生此結果的流程是計算從 0 到 9 的整數總和 (0+1+2+3+4+5+6+7+8+9 = 45)，並將這個總和存儲在變數 K 中。</p>
                        <p>一個可能的對應C程式碼片段如下：</p>
                        <pre><code class="language-c">int K = 0;
int I;
for (I = 0; I <= 9; I++) { // 迴圈執行10次 (I = 0, 1, ..., 9)
    K = K + I;
}
// 此時 K = 45
// printf("%d", K); // 最後一個列印方塊
</code></pre>
                        <p>變數追蹤表 (假設上述程式碼)：</p>
                        <table>
                            <thead><tr><th>迴圈開始前 I</th><th>迴圈開始前 K</th><th>條件 (I &lt;= 9)</th><th>執行 K += I</th><th>執行後 K</th><th>執行 I++</th></tr></thead>
                            <tbody>
                                <tr><td>0</td><td>0</td><td>0 &lt;= 9 (True)</td><td>K = 0+0 = 0</td><td>0</td><td>1</td></tr>
                                <tr><td>1</td><td>0</td><td>1 &lt;= 9 (True)</td><td>K = 0+1 = 1</td><td>1</td><td>2</td></tr>
                                <tr><td>2</td><td>1</td><td>2 &lt;= 9 (True)</td><td>K = 1+2 = 3</td><td>3</td><td>3</td></tr>
                                <tr><td colspan="6" style="text-align:center;">...</td></tr>
                                <tr><td>9</td><td>36</td><td>9 &lt;= 9 (True)</td><td>K = 36+9 = 45</td><td>45</td><td>10</td></tr>
                                <tr><td>10</td><td>45</td><td>10 &lt;= 9 (False)</td><td colspan="3">迴圈終止</td></tr>
                            </tbody>
                        </table>
                        <p>關於其他選項的分析 (基於上述假設的流程)：</p>
                        <ul>
                            <li>(B) 變數 Q 未在假設的流程中定義。</li>
                            <li>(C) 在上述假設中，迴圈 (I 從 0 到 9) 總共執行 10 次，而非 9 次。</li>
                            <li>(D) 變數 Y 未在假設的流程中定義。</li>
                        </ul>
                        <p>在沒有實際流程圖的情況下，我們基於答案 (A) 進行反向推導，認為 K 是累加結果。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A) (根據題目提供)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q48">下一題</button></div>
                </div>

                <div id="q48" class="quiz-card">
                    <h3>48. 下列 c 語言程式碼片段執行後，變數 y 的值為何？</h3>
                    <pre><code class="language-c">int y, a=45;
if(a>=60)
  y=a+1;
else if(a>=50)
  y=a+2;
else
  y=a+3;
</code></pre>
                    <button class="run-example-btn" data-code-id="q48-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 45</div>
                        <div class="option" data-option="B">(B) 46</div>
                        <div class="option" data-option="C">(C) 47</div>
                        <div class="option" data-option="D">(D) 48</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路</h4>
                        <ol>
                            <li>變數初始化：<code>int a=45;</code>。變數 <code>y</code> 被宣告但未在此時初始化。</li>
                            <li>第一個 <code>if</code> 條件判斷：<code>(a >= 60)</code>。
                                <ul><li>代入 <code>a</code> 的值：<code>(45 >= 60)</code>。</li><li>此條件為假 (False)。</li></ul>
                            </li>
                            <li>由於第一個 <code>if</code> 條件為假，程式繼續到 <code>else if</code> 條件判斷：<code>(a >= 50)</code>。
                                <ul><li>代入 <code>a</code> 的值：<code>(45 >= 50)</code>。</li><li>此條件也為假 (False)。</li></ul>
                            </li>
                            <li>由於前面的 <code>if</code> 和 <code>else if</code> 條件都為假，程式執行最後的 <code>else</code> 區塊。</li>
                            <li>在 <code>else</code> 區塊中執行：<code>y = a + 3;</code>
                                <ul><li>代入 <code>a</code> 的值：<code>y = 45 + 3;</code></li><li>計算結果：<code>y = 48</code>。</li></ul>
                            </li>
                        </ol>
                        <p>因此，變數 <code>y</code> 的最終值為 48。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q49">下一題</button></div>
                </div>

                <div id="q49" class="quiz-card">
                    <h3>49. 下列 C 語言程式碼片段執行結果，變數 total 的值為何？</h3>
                    <pre><code class="language-c">int i, total=0;
for( i=1; i&lt;8; i+=2)
  total+=i;
</code></pre>
                    <button class="run-example-btn" data-code-id="q49-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 4</div>
                        <div class="option" data-option="B">(B) 8</div>
                        <div class="option" data-option="C">(C) 16</div>
                        <div class="option" data-option="D">(D) 28</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>變數 <code>total</code> 初始化為 0。<code>for</code> 迴圈的計數器 <code>i</code> 從 1 開始，條件是 <code>i < 8</code>，每次迭代後 <code>i</code> 增加 2。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 i</th><th>迴圈開始前 total</th><th>條件 (i &lt; 8)</th><th>條件結果</th><th>執行 total += i</th><th>執行後 total</th><th>執行 i += 2 (i變為)</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>1 (初始)</td><td>0 (初始)</td><td>1 &lt; 8</td><td>True</td><td>total = 0 + 1 = 1</td><td>1</td><td>3</td></tr>
                                <tr><td>3</td><td>1</td><td>3 &lt; 8</td><td>True</td><td>total = 1 + 3 = 4</td><td>4</td><td>5</td></tr>
                                <tr><td>5</td><td>4</td><td>5 &lt; 8</td><td>True</td><td>total = 4 + 5 = 9</td><td>9</td><td>7</td></tr>
                                <tr><td>7</td><td>9</td><td>7 &lt; 8</td><td>True</td><td>total = 9 + 7 = 16</td><td>16</td><td>9</td></tr>
                                <tr><td>9</td><td>16</td><td>9 &lt; 8</td><td>False</td><td>- (不執行)</td><td>16 (迴圈終止)</td><td>-</td></tr>
                            </tbody>
                        </table>
                        <p>迴圈執行時，<code>i</code> 的值依次為 1, 3, 5, 7。
                        <code>total</code> 的累加過程：
                        <ul>
                            <li>當 i=1: <code>total = 0 + 1 = 1</code></li>
                            <li>當 i=3: <code>total = 1 + 3 = 4</code></li>
                            <li>當 i=5: <code>total = 4 + 5 = 9</code></li>
                            <li>當 i=7: <code>total = 9 + 7 = 16</code></li>
                        </ul>
                        當 <code>i</code> 變為 9 時，條件 <code>9 < 8</code> 為假，迴圈終止。最終 <code>total</code> 的值為 16。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q50">下一題</button></div>
                </div>

                <div id="q50" class="quiz-card">
                    <h3>50. 下列 C 語言程式碼片段執行結果，變數 y 的值為何？</h3>
                    <pre><code class="language-c">int y, r, a=30, b=42;
r=a%b;
while(r!=0) {
  a=b;
  b=r;
  r=a%b;
}
y=b;
</code></pre>
                    <button class="run-example-btn" data-code-id="q50-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 42</div>
                        <div class="option" data-option="B">(B) 30</div>
                        <div class="option" data-option="C">(C) 12</div>
                        <div class="option" data-option="D">(D) 6</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤 (輾轉相除法)</h4>
                        <p>此程式碼使用輾轉相除法（歐幾里得算法）來計算 <code>a</code> 和 <code>b</code> 的最大公因數 (GCD)。結果儲存在 <code>y</code> (其值等於迴圈結束時的 <code>b</code>)。</p>
                        <p>初始值：<code>a = 30</code>, <code>b = 42</code>。</p>
                        <p><b>迴圈前：</b> <code>r = a % b = 30 % 42 = 30</code>。</p>
                        <table>
                            <thead>
                                <tr><th>迴圈開始前 r</th><th>條件 (r != 0)</th><th>條件結果</th><th>執行 a=b (a變為)</th><th>執行 b=r (b變為)</th><th>執行 r=a%b (r變為)</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>30</td><td>30 != 0</td><td>True</td><td>a = 42</td><td>b = 30</td><td>r = 42 % 30 = 12</td></tr>
                                <tr><td>12</td><td>12 != 0</td><td>True</td><td>a = 30</td><td>b = 12</td><td>r = 30 % 12 = 6</td></tr>
                                <tr><td>6</td><td>6 != 0</td><td>True</td><td>a = 12</td><td>b = 6</td><td>r = 12 % 6 = 0</td></tr>
                                <tr><td>0</td><td>0 != 0</td><td>False</td><td colspan="3">- (迴圈終止)</td></tr>
                            </tbody>
                        </table>
                        <p>迴圈終止後，<code>a</code> 的值是 12，<code>b</code> 的值是 6，<code>r</code> 的值是 0。</p>
                        <p>接著執行 <code>y = b;</code>，所以 <code>y = 6</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q51">下一題</button></div>
                </div>

                <div id="q51" class="quiz-card">
                    <h3>51. 阿華想要了解 C 語言程式 if 條件敘述中常用的運算子&amp;與&&的不同，撰寫如下程式，下列何者為程式執行結果？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main() {
  int a=0x0a;
  int b=0x05;
  if(a & b)
    printf("a&b=%d\n", a&b);
  else
    printf("a&&b=%d\n", a&&b);
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q51-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) a&&b=1</div>
                        <div class="option" data-option="B">(B) a&&b=0</div>
                        <div class="option" data-option="C">(C) a&b=1</div>
                        <div class="option" data-option="D">(D) a&b=0</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路</h4>
                        <ol>
                            <li>變數初始化：
                                <ul>
                                    <li><code>int a = 0x0a;</code> // <code>a</code> 為十六進位的 0A，即十進位的 10。其二進位（假設至少8位元）為 <code>00001010</code>。</li>
                                    <li><code>int b = 0x05;</code> // <code>b</code> 為十六進位的 05，即十進位的 5。其二進位表示為 <code>00000101</code>。</li>
                                </ul>
                            </li>
                            <li><code>if</code> 條件判斷：<code>(a & b)</code>
                                <ul>
                                    <li><code>&</code> 是位元 AND (Bitwise AND) 運算子。它對 <code>a</code> 和 <code>b</code> 的每一對應位元執行 AND 操作。</li>
                                    <li>計算 <code>a & b</code>：
                                        <pre><code class="language-text">  00001010  (a = 10)
& 00000101  (b = 5)
----------
  00000000  (結果 = 0)</code></pre>
                                    </li>
                                    <li>所以 <code>(a & b)</code> 的結果是 0。</li>
                                    <li>在 C 語言的 <code>if</code> 條件中，0 被視為假 (False)。</li>
                                    <li>因此，<code>if(0)</code> 的條件為假。</li>
                                </ul>
                            </li>
                            <li>由於 <code>if</code> 條件為假，程式執行 <code>else</code> 區塊的內容：<code>printf("a&&b=%d\n", a&&b);</code></li>
                            <li>在 <code>else</code> 區塊中，計算 <code>a && b</code>：
                                <ul>
                                    <li><code>&&</code> 是邏輯 AND (Logical AND) 運算子。</li>
                                    <li>對於邏輯運算子，任何非零值都被視為真 (True)，只有 0 被視為假 (False)。</li>
                                    <li><code>a</code> (值為 10) 是非零，所以為真 (True)。</li>
                                    <li><code>b</code> (值為 5) 是非零，所以為真 (True)。</li>
                                    <li><code>True && True</code> 的結果是真 (True)。</li>
                                    <li>邏輯運算的真 (True) 結果在 C 中通常以整數 1 表示。</li>
                                    <li>所以 <code>a && b</code> 的結果是 1。</li>
                                </ul>
                            </li>
                            <li><code>printf</code> 語句將會印出 "a&&b=1"。</li>
                        </ol>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q52">下一題</button></div>
                </div>

                <div id="q52" class="quiz-card">
                    <h3>52. 曉華想要知道三角函數 sin(x)在 x=0 之後遞增的變化情形，寫了如下的 C 語言程式碼，卻發現迴圈內行號 8 和行號 9 的程式碼只執行了一次，下列哪一種修改程式的方式可以讓迴圈內的程式碼多執行幾次？ (提示：sin(1)=0.8415)</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
#include &lt;math.h&gt;
int main(){
  int x = 0;
  double y = 0.0;
  do{
    y = 10*sin(x);
    printf("x=%d, y=%lf\n", x,	y);
  } while(++x &lt;= y);
  printf("end of program\n");
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q52-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 把行號 3 中的 x=100 改為 x=0</div>
                        <div class="option" data-option="B">(B) 把行號 10 中的++x 改為 x++</div>
                        <div class="option" data-option="C">(C) 把行號 6 中 y 的初始值改為 –1.0</div>
                        <div class="option" data-option="D">(D) 把行號 3 中 x 的初始值改為 1</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤 (原程式碼)</h4>
                        <p>初始狀態: <code>x = 0</code>, <code>y = 0.0</code>。迴圈是 <code>do-while</code>，所以迴圈體至少執行一次。</p>
                        <p><b>第一次迭代 (也是唯一一次)：</b></p>
                        <table>
                            <thead><tr><th>步驟</th><th>變數 x</th><th>變數 y</th><th>動作</th><th>條件檢查 (<code>++x <= y</code>)</th></tr></thead>
                            <tbody>
                                <tr><td>開始</td><td>0</td><td>0.0</td><td>-</td><td>-</td></tr>
                                <tr><td>1</td><td>0</td><td>0.0</td><td><code>y = 10*sin(0)</code> => <code>y = 10 * 0.0 = 0.0</code></td><td>-</td></tr>
                                <tr><td>2</td><td>0</td><td>0.0</td><td><code>printf("x=0, y=0.000000\n")</code></td><td>-</td></tr>
                                <tr><td>3 (條件)</td><td>0</td><td>0.0</td><td><code>++x</code> (x 變為 1)</td><td><code>1 <= 0.0</code>  結果為 <b>False</b></td></tr>
                            </tbody>
                        </table>
                        <p>由於條件 <code>1 <= 0.0</code> 為 False，迴圈終止。因此原程式碼只執行一次。</p>
                        <h4>✓ 分析選項以增加執行次數：</h4>
                        <ul>
                            <li><b>(A) 把行號 3 中的 x=100 改為 x=0：</b> 行號 3 是註解掉的全域變數，修改它不影響 <code>main</code> 內的區域變數 <code>x</code>。</li>
                            <li><b>(B) 把行號 10 中的 <code>++x</code> 改為 <code>x++</code>：</b>
                                <p>條件變為 <code>while(x++ <= y)</code>。追蹤：</p>
                                <p><b>第一次迭代：</b></p>
                                <table>
                                    <thead><tr><th>步驟</th><th>變數 x</th><th>變數 y</th><th>動作</th><th>條件檢查 (<code>x++ <= y</code>)</th><th>x 在比較後的值</th></tr></thead>
                                    <tbody>
                                        <tr><td>開始</td><td>0</td><td>0.0</td><td>-</td><td>-</td><td>-</td></tr>
                                        <tr><td>1</td><td>0</td><td>0.0</td><td><code>y = 10*sin(0) = 0.0</code></td><td>-</td><td>0</td></tr>
                                        <tr><td>2</td><td>0</td><td>0.0</td><td><code>printf("x=0, y=0.0...")</code></td><td>-</td><td>0</td></tr>
                                        <tr><td>3 (條件)</td><td>0</td><td>0.0</td><td>比較 <code>0 <= 0.0</code> (True)</td><td><code>x++</code> (x 變為 1)</td><td>1</td></tr>
                                    </tbody>
                                </table>
                                <p><b>第二次迭代：</b></p>
                                <table>
                                    <thead><tr><th>步驟</th><th>變數 x</th><th>變數 y</th><th>動作</th><th>條件檢查 (<code>x++ <= y</code>)</th><th>x 在比較後的值</th></tr></thead>
                                    <tbody>
                                        <tr><td>開始</td><td>1</td><td>0.0 (前一輪的y)</td><td>-</td><td>-</td><td>-</td></tr>
                                        <tr><td>1</td><td>1</td><td>0.0</td><td><code>y = 10*sin(1)</code> (sin(1) ≈ 0.8415) => <code>y ≈ 8.415</code></td><td>-</td><td>1</td></tr>
                                        <tr><td>2</td><td>1</td><td>8.415</td><td><code>printf("x=1, y=8.415...")</code></td><td>-</td><td>1</td></tr>
                                        <tr><td>3 (條件)</td><td>1</td><td>8.415</td><td>比較 <code>1 <= 8.415</code> (True)</td><td><code>x++</code> (x 變為 2)</td><td>2</td></tr>
                                    </tbody>
                                </table>
                                <p>這個修改使得迴圈至少會執行第二次，因為 <code>x++</code> 使用 <code>x</code> 的原始值進行比較。只要 <code>sin(x)</code> 的值足夠大，迴圈就會繼續。</p>
                            </li>
                            <li><b>(C) 把行號 6 中 y 的初始值改為 –1.0：</b>
                                <p><b>第一次迭代：</b></p>
                                <ol>
                                    <li><code>x=0</code>, <code>y</code> (初始-1.0) 會被 <code>y = 10 * sin(0) = 0.0</code> 覆蓋。</li>
                                    <li>條件 <code>++x <= y</code> 仍是 <code>1 <= 0.0</code> (False)。</li>
                                </ol>
                                <p>此修改仍然只執行一次。</p>
                            </li>
                             <li><b>(D) 把行號 3 中 x 的初始值改為 1：</b> 同 (A)，不影響。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q53">下一題</button></div>
                </div>

                <div id="q53" class="quiz-card">
                    <h3>53. 如下 C 語言程式，當程式執行完畢後，輸出為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  unsigned char i=3;
  switch ( (i&0x0e) % 5){
    case(1):
      printf("%c", '0'+i);
      break;
    case(2):
      printf("%c", '0'+i*i);
    case(3):
      printf("%c", 'a'+i*i);
    default:
      printf("%c", 'z');
  }
  printf("\n");
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q53-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 9jz</div>
                        <div class="option" data-option="B">(B) 927z</div>
                        <div class="option" data-option="C">(C) 9270</div>
                        <div class="option" data-option="D">(D) 9</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路</h4>
                        <ol>
                            <li>變數初始化：<code>unsigned char i = 3;</code>。
                                <ul><li><code>i</code> 的二進位表示 (假設8位元)：<code>00000011</code>。</li></ul>
                            </li>
                            <li><code>switch</code> 條件計算：<code>(i & 0x0e) % 5</code>
                                <ul>
                                    <li><code>0x0e</code> 是十六進位，等於十進位的 14。其二進位表示為 <code>00001110</code>。</li>
                                    <li>位元 AND 運算 <code>i & 0x0e</code>：
                                        <pre><code class="language-text">  00000011 (i = 3)
& 00001110 (0x0e = 14)
----------
  00000010 (結果 = 2)</code></pre>
                                    </li>
                                    <li>取模運算：<code>2 % 5 = 2</code>。</li>
                                    <li>所以 <code>switch</code> 的判斷值為 2。</li>
                                </ul>
                            </li>
                            <li><code>switch</code> 執行：
                                <ul>
                                    <li><code>case(1):</code> 不匹配 (2 != 1)。</li>
                                    <li><code>case(2):</code> 匹配 (2 == 2)。
                                        <ul>
                                            <li>執行 <code>printf("%c", '0' + i * i);</code>。
                                                <ul>
                                                    <li><code>i * i = 3 * 3 = 9</code>。</li>
                                                    <li><code>'0' + 9</code>：字元 '0' (ASCII 48) 加上 9，得到 ASCII 57，即字元 '9'。</li>
                                                    <li>印出字元 '9'。</li>
                                                </ul>
                                            </li>
                                            <li><b>注意：</b><code>case(2):</code> 後面沒有 <code>break;</code> 語句，所以程式會繼續執行（fall-through）到下一個 <code>case</code>。</li>
                                        </ul>
                                    </li>
                                    <li><code>case(3):</code> 由於 fall-through，此區塊也會執行。
                                        <ul>
                                            <li>執行 <code>printf("%c", 'a' + i * i);</code>。
                                                <ul>
                                                    <li><code>i * i = 3 * 3 = 9</code>。</li>
                                                    <li><code>'a' + 9</code>：字元 'a' (ASCII 97) 加上 9，得到 ASCII 106，即字元 'j'。</li>
                                                    <li>印出字元 'j'。</li>
                                                </ul>
                                            </li>
                                            <li><b>注意：</b><code>case(3):</code> 後面也沒有 <code>break;</code> 語句，程式繼續 fall-through。</li>
                                        </ul>
                                    </li>
                                    <li><code>default:</code> 由於 fall-through，此區塊也會執行。
                                        <ul>
                                            <li>執行 <code>printf("%c", 'z');</code>。</li>
                                            <li>印出字元 'z'。</li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ol>
                        <p>綜合以上，程式的輸出順序是 '9', 'j', 'z'。因此，完整輸出為 "9jz"。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
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
                    <textarea id="code-editor" spellcheck="false"></textarea>
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
            // --- Sample Code Snippets ---
            const codeSamples = {
                'q1-code': `// Conceptual code, assuming Printout is a function call
// To make this runnable, define Printout or replace with printf.
#include <stdio.h>

void Printout() {
    // printf("Executing Printout\\n");
}

int main() {
    int k=6;
    int count = 0;
    do {
        Printout();
        count++;
        k=k*2;
        // printf("k = %d\\n", k);
    } while (k<100);
    printf("Printout executed %d times.\\n", count);
    return 0;
}`,
                'q3-code': `#include <stdio.h>\n\nint main() {\n    int count=0;\n    for(int i=5; i<=10; i=i+1)\n      for(int j=1; j<=i; j=j+1)\n        for (int k=1; k<=j; k=k+1)\n          if (i==j) count=count+1;\n    printf("count = %d\\n", count);\n    return 0;\n}`,
                'q4-code': `#include <stdio.h>\n\nint main() {\n    int n=0; int x=0;\n    do {\n      x += n;\n      n++;\n    } while (n<10);\n    printf("x = %d\\n", x);\n    return 0;\n}`,
                'q5-code': `#include <stdio.h>\n\nint main() {\n    int i = 2;\n    int executions = 0;\n    while (i < 800) {\n        i = i * i;\n        executions++;\n    }\n    printf("i = i * i executed %d times.\\n", executions);\n    printf("Final i = %d\\n", i);\n    return 0;\n}`,
                'q6-code': `#include <stdio.h>\n\nint main() {\n    int i = 1;\n    // This is an infinite loop as 'i' is not changed.\n    // To prevent browser freeze, let's limit it for demonstration.\n    int limit = 0;\n    while (i <= 10 && limit < 20) {\n        puts("happy");\n        // i++; // Missing increment for 'i' causes infinite loop in original problem\n        limit++;\n    }\n    if (limit >= 20) printf("Loop limited for demo purposes.\\n");\n    return 0;\n}`,
                'q7-code': `#include <stdio.h>\n\nint f(){\n  int p=2;\n  while(p<2000){\n    p=2*p;\n  }\n  return p;\n}\n\nint main() {\n    printf("f() returns: %d\\n", f());\n    return 0;\n}`,
                'q8-code': `#include <stdio.h>\n\nint main() {\n    int k = 2, m=10000;\n    int executions = 0;\n    do {\n      m = m / k;\n      k = k * 3;\n      executions++;\n      // printf("m=%d, k=%d\\n", m, k);\n    } while (k<120);\n    printf("m = m / k executed %d times.\\n", executions);\n    return 0;\n}`,
                'q9-code': `#include <stdio.h>\n\nint main() {\n    int x = 50; int y = 90;\n    if (y<95) {\n      if (y<200) x = 30;\n      else x =45;\n    } \n    printf("x = %d\\n", x);\n    return 0;\n}`,
                'q10-code': `#include <stdio.h>\n\nint main() {\n    int s = 0;\n    for (int i=2; i<=100; i+=2) s+=i;\n    printf("s = %d\\n", s);\n    return 0;\n}`,
                'q11-code': `#include <stdio.h>\n\nint main() {\n    int i;\n    for (i = 7; i <= 72; i += 7)\n      ;\n    printf("i is %d\\n", i);\n    return 0;\n}`,
                'q16-code': `#include <stdio.h>\n\nint main() {\n    int k = 10000;\n    int count = 0;\n    while (k >= 2) {\n        k = k / 8;\n        count++;\n    }\n    printf("k=k/8 executed %d times. Final k=%d\\n", count, k);\n    return 0;\n}`,
                'q17-code': `#include <stdio.h>\n\nint main() {\n    int i=2;\n    int executions = 0;\n    while(i<800) {\n        i=i*i;\n        executions++;\n    }\n    printf("i=i*i executed %d times. Final i=%d\\n", executions, i);\n    return 0;\n}`,
                'q18-code': `#include <stdio.h>\n\nint main(){\n  int number=1061130, result;\n  do {\n    result = number %10;\n    printf("%i", result); \n    number = number/10;\n  } while(number != 0);\n  printf("\\n"); \n  return 0;\n}`,
                'q19-code': `#include <stdio.h>\n\nint main() {\n    int x=4; int sum=0;\n    while (x<=100){\n      sum+=x;\n      x+=4;\n    }\n    printf("sum=%d\\n", sum);\n    return 0;\n}`,
                'q21-code': `#include <stdio.h>\n\nint main() {\n    int k_actual = 2;\n    int actual_executions = 0;\n    while(k_actual <= 65535 && k_actual > 0 && actual_executions < 10) { \n        k_actual = k_actual*k_actual;\n        actual_executions++;\n    }\n    printf("Estimated executions based on values: 4 (actual might differ due to int limits or demo limits)\\n");\n    // The core idea is 2->4->16->256->65536. 65536 > 65535, so 4 steps.\n    return 0;\n}`,
                'q22-code': `#include <stdio.h>\n\nint main() {\n    int n=0; int i=1;\n    while(i<=100){\n      n=n+i;\n      i=i+2;\n    }\n    printf("%d\\n", n);\n    return 0;\n}`,
                'q24-code': `#include <stdio.h>\n\nint main(){\n  int y1, y2=13, y3=1;\n  for (y1=0; y1<=y2; ){\n    y3 += y1;\n    y1 += 2;\n  }\n  printf("%i\\n", y3);\n  return 0;\n}`,
                'q25-code': `#include <stdio.h>\n\nint main() {\n    int n = 1234; \n    int sum=0;\n    while(n!=0){\n      sum=sum+n%10;\n      n=n/10;\n    }\n    printf("Sum of digits: %d\\n", sum);\n    return 0;\n}`,
                'q26-code': `#include <stdio.h>\n\nint main(){ \n  int x=110, y=20;\n  while(x>120){\n    y=x-y;\n    x++;\n  }\n  printf("%3d%3d\\n", x, y);\n  return 0;\n}`,
                'q27-code': `#include <stdio.h>\n\nint main(){ \n  int x=0, y=0;\n  for(y=1; y<=20; y++) {\n    int z=y%5;\n    if(z==0) x++;\n  }\n  printf("%3d%3d\\n",x,y);\n  return 0;\n}`,
                'q28-code': `#include <stdio.h>\n\nint main(){ \n  int a=5, b=2;\n  if(a>b){\n    a=a*b+2;\n    b++;\n  } else {\n    a=a/2;\n    b=b+4;\n  }\n  printf("%3d%3d\\n",a,b);\n  return 0;\n}`,
                'q29-code': `#include <stdio.h>\n\nint main(){ \n  int n=4, x=7, y=8;\n  switch(n){\n    case 1: x=n;break;\n    case 2: y=y+4;\n    case 3: x=n+5;break;\n    case 4: x=x*4;\n    default: y=y-4;\n  }\n  printf("%2d%2d\\n",x,y);\n  return 0;\n}`,
                'q30-code': `#include <stdio.h>\n\nint main(){ \n  int x=30, y=0; \n  if (x<=5) {\n    y=x*x; \n    x+=5;\n  } else {\n    if (x<10) y=x-2;\n    else {\n      if(x<25) y=x+10;\n      else y=x/10;\n    }\n    x++;\n  }\n  printf("%3d%3d\\n",y,x);\n  return 0;\n}`,
                'q31-code': `#include <stdio.h>\n\nint main(){\n  int x=3, y=6, z=0;\n  int inputs[] = {5, 2, -1, 10}; \n  int input_idx = 0;\n  do{\n    z = inputs[input_idx++]; \n    x = x+z+y;\n    y++;\n  } while(z<10);\n  y *= 2;\n  printf("%3d%3d%3d\\n",z,x,y);\n  return 0;\n}`,
                'q32-code': `#include <stdio.h>\n\nint main() {\n    int x=0; int sum=0;\n    while(x <= 200){\n      sum += x;\n      x += 2;\n    }\n    printf("sum=%d\\n", sum);\n    return 0;\n}`,
                'q33-code': `#include <stdio.h>\n\nint main(){\n  int a=1;\n  while(++a<5){\n    printf("%d ", a);\n  }\n  printf("\\n");\n  return 0;\n}`,
                'q34-code': `#include <stdio.h>\n\nint main(){\n  int a=1;\n  while(a++<5){\n    printf("%d ", a);\n  }\n  printf("\\n");\n  return 0;\n}`,
                'q35-code': `#include <stdio.h>\n\nint main(){\n  int a=1;\n  do{\n    printf("%d ", a);\n  }while(++a<5);\n  printf("\\n");\n  return 0;\n}`,
                'q36-code': `#include <stdio.h>\n\nint main(){\n  int a=1;\n  do{\n    printf("%d ", a);\n  }while(a++<5);\n  printf("\\n");\n  return 0;\n}`,
                'q37-code': `#include <stdio.h>\n\nint main(){\n  int m,n,r;\n  m=48; n=18; \n  r = m % n; \n  while (r != 0){\n    m = n;\n    n = r;\n    r = m % n;\n  }\n  printf("GCD (n) = %d\\n", n);\n  return 0;\n}`,
                'q38-code': `#include <stdio.h>\n\nint main(){ \n  int x=2, y=0;\n  for (y=1; y<=30; y++){\n    int z=y%6;\n    if (z==0) x+=2;\n  }\n  printf("%3d%3d\\n", x, y);\n  return 0;\n}`,
                'q39-code': `#include <stdio.h>\n#include <stdbool.h>\n\nint main(){ \n  int p,d;\n  bool flag;\n  int prime_count = 0; \n  int twelfth_prime_val = 0;\n  for (p=2; p<=50; ++p){\n    flag = true;\n    for (d=2; d<p; ++d) {\n      if (p%d == 0) {\n        flag=false;\n        break;\n      }\n    }\n    if (flag) {\n      prime_count++;\n      if (prime_count == 12) {\n        twelfth_prime_val = p;\n      }\n    }\n  }\n  printf("The 12th prime is: %d\\n", twelfth_prime_val);\n  return 0;\n}`,
                'q40-code': `#include <stdio.h>\n\nint main() {\n  int a,b,c;\n  a = 5; b = 10; // Simulating inputs\n  c=a;\n  if (b>c) c=b;\n  printf("the output is:%d\\n",c);\n  return 0;\n}`,
                'q41-code': `#include <stdio.h>\n\nint main(){\n  int x, y, z;\n  int temp;\n  x=7; y=2; z=5; // Example values\n  if(x>y){\n    temp = x; x = y; y = temp;\n  }\n  // Option B logic:\n  if (y > z){\n    temp = y; y = z; z = temp;\n  }\n  if (x>y){\n    temp = x; x = y; y = temp;\n  }\n  printf("Sorted: %d %d %d\\n", x, y, z);\n  return 0;\n}`,
                'q42-code': `#include <stdio.h>\n\nint main(){\n  int n;\n  int sum = 0;\n  n=1234; // Simulating input\n  while(n != 0){\n    sum += n%10;\n    n /= 10;\n  }\n  printf("Sum of digits: %d\\n", sum);\n  return 0;\n}`,
                'q44-code': `#include <stdio.h>\n\nint main() {\n  int newline_count = 0;\n  for (int i=1; i<=4; i++){\n    for (int j=1; j<5; j++)\n      printf("*");\n    printf("\\n");\n    newline_count++;\n  }\n  printf("printf(\\"\\n\\") executed %d times.\\n", newline_count);\n  return 0;\n}`,
                'q45-code': `#include <stdio.h>\n\nint main() {\n  float salary = 400.0f;\n  if (salary > 400.0f){\n    float bonus = 10.0f;\n    salary += bonus;\n  } else {\n    salary += salary * 0.2f;\n  }\n  printf("%.2f\\n", salary);\n  return 0;\n}`,
                'q46-code': `#include <stdio.h>\n\nint main() {\n  int n=4, a=1;\n  for (int i=1; i<=n; i++){\n    for (int c=1; c<=i; c++){\n      printf("%d", a);\n      a++;\n    }\n    printf("\\n");\n  }\n  return 0;\n}`,
                'q48-code': `#include <stdio.h>\n\nint main() {\n    int y=0, a=45;\n    if(a>=60)\n      y=a+1;\n    else if(a>=50)\n      y=a+2;\n    else\n      y=a+3;\n    printf("y = %d\\n", y);\n    return 0;\n}`,
                'q49-code': `#include <stdio.h>\n\nint main() {\n    int i, total=0;\n    for( i=1; i<8; i+=2)\n      total+=i;\n    printf("total = %d\\n", total);\n    return 0;\n}`,
                'q50-code': `#include <stdio.h>\n\nint main() {\n    int y, r, a=30, b=42;\n    r=a%b;\n    while(r!=0) {\n      a=b;\n      b=r;\n      r=a%b;\n    }\n    y=b;\n    printf("y (GCD) = %d\\n", y);\n    return 0;\n}`,
                'q51-code': `#include <stdio.h>\n\nint main() {\n  int a=0x0a; \n  int b=0x05; \n  if(a & b)\n    printf("a&b=%d\\n", a&b);\n  else\n    printf("a&&b=%d\\n", a&&b);\n  return 0;\n}`,
                'q52-code': `#include <stdio.h>\n#include <math.h>\n\nint main(){\n  int x_orig = 0;\n  double y_orig = 0.0;\n  int count_orig = 0;\n  // printf("Original loop:\\n");\n  do{\n    y_orig = 10*sin(x_orig);\n    // printf("x=%d, y=%lf\\n", x_orig, y_orig);\n    count_orig++;\n  } while(++x_orig <= y_orig && count_orig < 5); // Limiting for demo \n  // if (count_orig >=5 && !(++x_orig <= y_orig)) printf("Original loop would have continued if not limited for demo.\\n");\n\n  int x_mod = 0;\n  double y_mod = 0.0;\n  int count_mod = 0;\n  // printf("\\nModified loop (B - x++ <= y):\\n");\n  do{\n    y_mod = 10*sin(x_mod);\n    // printf("x=%d, y=%lf\\n", x_mod, y_mod);\n    count_mod++;\n  //} while(x_mod++ <= y_mod && count_mod < 10); // Limiting for demo\n  } while(x_mod++ <= y_mod); \n  // if (count_mod >=10 && !(x_mod++ <= y_mod)) printf("Modified loop would have continued if not limited for demo.\\n");\n\n  // printf("Original loop ran %d times.\\n", count_orig);\n  // printf("Modified loop ran %d times.\\n", count_mod);\n  printf("For the purpose of the question, focus on the condition logic change.\\n");\n  printf("end of program\\n");\n  return 0;\n}`,
                'q53-code': `#include <stdio.h>\n\nint main(){\n  unsigned char i=3;\n  switch ( (i&0x0e) % 5){\n    case(1):\n      printf("%c", '0'+i);\n      break;\n    case(2):\n      printf("%c", '0'+i*i);\n    case(3):\n      printf("%c", 'a'+i*i);\n    default:\n      printf("%c", 'z');\n  }\n  printf("\\n");\n  return 0;\n}`
            };
            const codeEditor = document.getElementById('code-editor');
            const outputArea = document.getElementById('output-area');
            const runCodeBtn = document.getElementById('run-code-btn');

            // --- Populate sandbox from "Run Example" buttons ---
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

            // --- Sandbox Execution Logic (iframe) ---
            runCodeBtn.addEventListener('click', async () => {
                outputArea.textContent = '編譯中，請稍候...';
                runCodeBtn.disabled = true;

                const oldIframe = document.getElementById('emcc-sandbox');
                if (oldIframe) {
                    oldIframe.remove();
                }

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
                    if (!js || !wasm) {
                        throw new Error('後端回應格式不正確，未包含 JS 或 WASM 資料。');
                    }

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

                        iframeWindow.parentPrint = (text) => {
                            outputArea.textContent += text + '\n';
                        };
                        iframeWindow.parentPrintError = (text) => {
                            outputArea.textContent += `[錯誤]: ${text}\n`;
                        };
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
                                onRuntimeInitialized: () => {
                                    // setTimeout(() => window.parentSignalEnd(), 50); // Adjusted to onExit
                                },
                                onExit: () => { window.parentSignalEnd(); } // Use onExit
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


            // --- Quiz Logic ---
            document.querySelectorAll('.quiz-options').forEach(optionsContainer => {
                optionsContainer.addEventListener('click', function(e) {
                    if (e.target.classList.contains('option') && !this.classList.contains('answered')) {
                        const selectedOption = e.target;
                        const correctAnswer = this.getAttribute('data-correct');
                        const selectedAnswer = selectedOption.getAttribute('data-option');

                        this.classList.add('answered'); // Mark the whole options container as answered

                        this.querySelectorAll('.option').forEach(opt => {
                           const optValue = opt.getAttribute('data-option');
                           const feedbackIcon = document.createElement('span');
                           feedbackIcon.classList.add('feedback-icon');

                           if(optValue === correctAnswer){
                               opt.classList.add('correct');
                               feedbackIcon.textContent = ' ✅';
                           } else if (optValue === selectedAnswer) { // Only mark the selected incorrect one
                               opt.classList.add('incorrect');
                               feedbackIcon.textContent = ' ❌';
                           }
                           // Add icon only if it's the selected one or the correct one
                           if (opt === selectedOption || optValue === correctAnswer) {
                                if(opt.querySelector('.feedback-icon') == null) { // Avoid duplicate icons
                                   opt.appendChild(feedbackIcon);
                                }
                           }
                           opt.classList.add('answered'); // Mark individual option as processed for styling hover
                        });

                        const explanation = this.closest('.quiz-card').querySelector('.explanation');
                        if (explanation) {
                            explanation.style.display = 'block';
                        }
                    }
                });
            });

            // --- Next Button Logic ---
            document.querySelectorAll('.next-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            // --- Resizer Logic ---
            const resizer = document.getElementById('dragMe');
            const leftSide = document.querySelector('.tutorial-content');
            // const rightSide = document.querySelector('.interactive-panel'); // Not directly used in width calc

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
                    // Add min/max width constraints if necessary
                    if (newLeftWidth > 200 && newLeftWidth < (document.body.clientWidth - 250)) { // Basic constraints
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

            // Set initial code in editor
            if (codeSamples['q1-code']) { // Check if q1-code exists, otherwise fallback
                 codeEditor.value = codeSamples['q1-code'];
            } else if (Object.keys(codeSamples).length > 0) {
                 codeEditor.value = codeSamples[Object.keys(codeSamples)[0]]; // Fallback to the first sample
            } else {
                 codeEditor.value = "// Welcome! Select a question with a code example, or write your own C code here.";
            }
        });
    </script>
</body>
</html>
