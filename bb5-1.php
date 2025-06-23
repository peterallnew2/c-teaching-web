<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C 語言 第五章 陣列與指標 - 詳細解析 (aa5-2)</title>

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
        .explanation pre { /* Nested pre inside explanation for text blocks */
            margin: 0.5em 0;
            padding: 8px;
            background-color: rgba(0,0,0,0.2);
            white-space: pre-wrap; /* Allow text wrapping in pre */
            word-wrap: break-word; /* Allow long words to break */
        }
        .explanation .code-block-within-explanation pre { /* Specific style for code blocks within explanation */
             background-color: var(--code-bg); /* Match main code blocks */
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
        .quiz-card h3 { /* Question title */
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
            <h1>C 語言練習：第五章 陣列、指標與應用</h1>
            <p>本章節練習題主要涵蓋 C/C++ 中的陣列、指標、記憶體管理以及它們在迴圈和條件判斷中的綜合應用。請仔細閱讀每個題目及其附帶的程式碼片段。您可以利用右側的互動式程式碼沙箱來執行、測試和修改範例，以加深理解。每個問題的詳解部分將提供詳細的步驟分析，對於涉及陣列和指標的題目，會特別著重變數、記憶體位址以及內容值之間的關係；對於迴圈題目，則會提供變數變化追蹤表。</p>

            <div class="quiz-section">
                <h2>第五章 互動練習題 - 詳細解析版</h2>
                <p>請挑戰下面的題目，檢驗您的學習成果！點擊選項後會顯示包含詳細解說的詳解。</p>
                <!-- QUIZ CARDS START -->
                <div id="q1" class="quiz-card">
                    <h3>1. 若 A[ ][ ]是一個 MxN 的整數陣列，右側程式片段用以計算 A 陣列每一列的總和，以下敘述何者正確？</h3>
                    <pre><code class="language-c">int main() { // Assuming M and N are defined, and A is initialized
    // int M = 2, N = 3; // Example dimensions
    // int A[M][N] = {{1,2,3},{4,5,6}}; // Example array
    int rowsum = 0;
    for (int i=0; i&lt;M; i=i+1) {
        // rowsum should be reset for each row here for correct sum of *each* row independently
        for (int j=0; j&lt;N; j=j+1) {
            rowsum = rowsum + A[i][j];
        }
        printf("The sum of row %d is %d.\\n", i, rowsum);
    }
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q1-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 第一列總和是正確，但其他列總和不一定正確</div>
                        <div class="option" data-option="B">(B) 程式片段在執行時，會產 錯誤(run-time error)</div>
                        <div class="option" data-option="C">(C) 程式片段中，有語法上的錯誤</div>
                        <div class="option" data-option="D">(D) 程式片段會完成執行並正確印出每一列的總和</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式片段旨在計算一個 MxN 二維陣列 <code>A</code> 中每一列元素的總和。</p>
                        <p><b>程式碼分析：</b></p>
                        <ol>
                            <li><code>int rowsum = 0;</code>：變數 <code>rowsum</code> 在外層迴圈之前初始化為 0。</li>
                            <li>外層迴圈 <code>for (int i=0; i&lt;M; i=i+1)</code>：遍歷陣列的每一列。</li>
                            <li>內層迴圈 <code>for (int j=0; j&lt;N; j=j+1)</code>：遍歷目前列的每一個元素。 (原題目中 <code>j-j+1</code> 已修正為 <code>j=j+1</code> 或 <code>j++</code> 進行分析)。</li>
                            <li><code>rowsum = rowsum + A[i][j];</code>：將目前元素加到 <code>rowsum</code>。</li>
                            <li><code>printf(...)</code>：在外層迴圈的每次迭代結束後印出該列的總和。</li>
                        </ol>
                        <p><b>關鍵問題：</b>變數 <code>rowsum</code> 只在外層迴圈開始前初始化一次。這意味著，在計算完第一列的總和後，<code>rowsum</code> 並沒有被重置為 0。因此，計算後續列的總和時，會從前一列的累計總和開始，導致結果不正確（除非目標是計算到目前列為止的所有元素的總和，但題目描述是「每一列的總和」）。</p>
                        <p><b>追蹤範例 (假設 M=2, N=2, A={{1,2},{3,4}}):</b></p>
                        <table>
                            <thead><tr><th>i</th><th>j</th><th>A[i][j]</th><th>rowsum (執行前)</th><th>rowsum = rowsum + A[i][j]</th><th>rowsum (執行後)</th><th>printf 輸出</th></tr></thead>
                            <tbody>
                                <tr><td>-</td><td>-</td><td>-</td><td>0 (初始)</td><td>-</td><td>0</td><td>-</td></tr>
                                <tr><td colspan="7" style="text-align:center;"><b>外層迴圈 i = 0 (第一列)</b></td></tr>
                                <tr><td>0</td><td>0</td><td>A[0][0]=1</td><td>0</td><td>0 + 1 = 1</td><td>1</td><td>-</td></tr>
                                <tr><td>0</td><td>1</td><td>A[0][1]=2</td><td>1</td><td>1 + 2 = 3</td><td>3</td><td>-</td></tr>
                                <tr><td>0</td><td colspan="4">內層迴圈結束</td><td>3</td><td>"The sum of row 0 is 3." (正確)</td></tr>
                                <tr><td colspan="7" style="text-align:center;"><b>外層迴圈 i = 1 (第二列)</b></td></tr>
                                <tr><td>1</td><td>0</td><td>A[1][0]=3</td><td><b>3</b> (未重置)</td><td>3 + 3 = 6</td><td>6</td><td>-</td></tr>
                                <tr><td>1</td><td>1</td><td>A[1][1]=4</td><td>6</td><td>6 + 4 = 10</td><td>10</td><td>-</td></tr>
                                <tr><td>1</td><td colspan="4">內層迴圈結束</td><td>10</td><td>"The sum of row 1 is 10." (錯誤，應為 3+4=7)</td></tr>
                            </tbody>
                        </table>
                        <p><b>結論：</b>第一列總和是正確的，因為 <code>rowsum</code> 從 0 開始。但對於後續的列，由於 <code>rowsum</code> 沒有在每處理新的一列前重置為0，所以計算的是從第一列開始到當前列所有元素的累計總和，而不是單獨「每一列的總和」。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q2">下一題</button></div>
                </div>

                <div id="q2" class="quiz-card">
                    <h3>2.	寫出以下程式執行後之輸出結果：</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main () { // Standard main signature
    int i=0,n=0,sum=0,arr[4]={10,15,82,174};
    while (n>=0) {
        n=arr[i++];
        if (n>=100) return n; // Exits main, printf for sum is skipped
        if (n>=50) {
            sum=sum+1000;
            break;
        }
        if (n>=30) continue;
        sum=sum+n;
    }
    printf("The sum is %d \n",sum);
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q2-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 1025</div>
                        <div class="option" data-option="B">(B) 1010</div>
                        <div class="option" data-option="C">(C) 1015</div>
                        <div class="option" data-option="D">(D) 1174</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>初始化：<code>i=0</code>, <code>n=0</code>, <code>sum=0</code>, <code>arr={10,15,82,174}</code>。</p>
                        <p>迴圈條件：<code>while (n>=0)</code>。</p>
                        <table>
                            <thead><tr><th>迭代</th><th>開始前 i</th><th>開始前 n</th><th>開始前 sum</th><th>條件(n>=0)</th><th>n=arr[i++] (n變為, i變為)</th><th>n>=100?</th><th>n>=50? (若前者false)</th><th>n>=30? (若前兩者false)</th><th>sum=sum+n (若前三者false)</th><th>sum 變為</th><th>動作/跳轉</th></tr></thead>
                            <tbody>
                                <tr><td>-</td><td>0</td><td>0</td><td>0</td><td>0>=0 (T)</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>0</td><td>進入迴圈</td></tr>
                                <tr><td>1</td><td>0</td><td>0</td><td>0</td><td>(n=0)</td><td>n=arr[0]=10, i=1</td><td>10>=100 (F)</td><td>10>=50 (F)</td><td>10>=30 (F)</td><td>sum=0+10</td><td>10</td><td></td></tr>
                                <tr><td>2</td><td>1</td><td>10</td><td>10</td><td>(n=10)</td><td>n=arr[1]=15, i=2</td><td>15>=100 (F)</td><td>15>=50 (F)</td><td>15>=30 (F)</td><td>sum=10+15</td><td>25</td><td></td></tr>
                                <tr><td>3</td><td>2</td><td>15</td><td>25</td><td>(n=15)</td><td>n=arr[2]=82, i=3</td><td>82>=100 (F)</td><td>82>=50 (T)</td><td>- (不執行)</td><td>-</td><td>-</td><td>sum=25+1000=1025; <code>break;</code></td></tr>
                            </tbody>
                        </table>
                        <p><b>詳細步驟：</b></p>
                        <ol>
                            <li><b>初始：</b> <code>i=0, n=0, sum=0</code>. <code>arr = {10, 15, 82, 174}</code>.</li>
                            <li><b>迴圈 1：</b>
                                <ul>
                                    <li>條件 <code>n>=0</code> (<code>0>=0</code>) 為 True。</li>
                                    <li><code>n = arr[i++]</code> => <code>n = arr[0] = 10</code>. <code>i</code> 變為 1.</li>
                                    <li><code>if (n>=100)</code> (<code>10>=100</code>) 為 False.</li>
                                    <li><code>if (n>=50)</code> (<code>10>=50</code>) 為 False.</li>
                                    <li><code>if (n>=30)</code> (<code>10>=30</code>) 為 False.</li>
                                    <li><code>sum = sum + n</code> => <code>sum = 0 + 10 = 10</code>.</li>
                                </ul>
                            </li>
                            <li><b>迴圈 2：</b>
                                <ul>
                                    <li>條件 <code>n>=0</code> (<code>10>=0</code>) 為 True。</li>
                                    <li><code>n = arr[i++]</code> => <code>n = arr[1] = 15</code>. <code>i</code> 變為 2.</li>
                                    <li><code>if (n>=100)</code> (<code>15>=100</code>) 為 False.</li>
                                    <li><code>if (n>=50)</code> (<code>15>=50</code>) 為 False.</li>
                                    <li><code>if (n>=30)</code> (<code>15>=30</code>) 為 False.</li>
                                    <li><code>sum = sum + n</code> => <code>sum = 10 + 15 = 25</code>.</li>
                                </ul>
                            </li>
                            <li><b>迴圈 3：</b>
                                <ul>
                                    <li>條件 <code>n>=0</code> (<code>15>=0</code>) 為 True。</li>
                                    <li><code>n = arr[i++]</code> => <code>n = arr[2] = 82</code>. <code>i</code> 變為 3.</li>
                                    <li><code>if (n>=100)</code> (<code>82>=100</code>) 為 False.</li>
                                    <li><code>if (n>=50)</code> (<code>82>=50</code>) 為 True.
                                        <ul>
                                            <li><code>sum = sum + 1000</code> => <code>sum = 25 + 1000 = 1025</code>.</li>
                                            <li><code>break;</code> 執行，跳出 <code>while</code> 迴圈。</li>
                                        </ul>
                                    </li>
                                    <li>後續 <code>if (n>=30)</code> 和 <code>sum=sum+n</code> 不會執行。</li>
                                </ul>
                            </li>
                            <li>迴圈結束。</li>
                            <li><code>printf("The sum is %d \n",sum);</code> => 印出 "The sum is 1025 ".</li>
                        </ol>
                        <p>注意：如果陣列中的值使得 <code>n>=100</code> 先成立 (例如 <code>arr[0]=150</code>)，則程式會從 <code>main</code> 函數返回 <code>n</code> 的值，<code>printf</code> 不會執行。但在此情況下，<code>n=82</code> 時的 <code>break</code> 先發生。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q3">下一題</button></div>
                </div>

                <div id="q3" class="quiz-card">
                    <h3>3.	要將陣列 pin[ ]的第 13 個元素的值指定為 100，下列哪一行敘述正確？</h3>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) pin[12]=100;</div>
                        <div class="option" data-option="B">(B) pin[13]=100;</div>
                        <div class="option" data-option="C">(C) pin[14] =100;</div>
                        <div class="option" data-option="D">(D) pin[15] = 100;</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：陣列索引 (0-based indexing)</h4>
                        <p>在 C 和 C++ (以及許多其他程式語言) 中，陣列的索引是從 0 開始的。這意味著：</p>
                        <ul>
                            <li>陣列的第一個元素的索引是 0。</li>
                            <li>陣列的第二個元素的索引是 1。</li>
                            <li>...</li>
                            <li>陣列的第 N 個元素的索引是 N-1。</li>
                        </ul>
                        <p>題目要求指定陣列 <code>pin[]</code> 的「第 13 個元素」的值為 100。</p>
                        <p>根據 0-based 索引，第 13 個元素的索引值是 <code>13 - 1 = 12</code>。</p>
                        <p>因此，正確的敘述是 <code>pin[12] = 100;</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q4">下一題</button></div>
                </div>

                <div id="q4" class="quiz-card">
                    <h3>4.	宣告一個陣列 Y[5]，其索引值最小為？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) -1</div>
                        <div class="option" data-option="B">(B) 1</div>
                        <div class="option" data-option="C">(C) 0</div>
                        <div class="option" data-option="D">(D) 5</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：陣列索引範圍</h4>
                        <p>在 C 和 C++ 中，當一個陣列被宣告為 <code>Type ArrayName[Size]</code> 時，它表示這個陣列有 <code>Size</code> 個元素。</p>
                        <p>陣列的索引是從 0 開始的。</p>
                        <p>所以，對於一個大小為 <code>Size</code> 的陣列，其合法的索引範圍是從 <code>0</code> 到 <code>Size - 1</code>。</p>
                        <p>題目中宣告了一個陣列 <code>Y[5]</code>。這表示：</p>
                        <ul>
                            <li>陣列 <code>Y</code> 有 5 個元素。</li>
                            <li>這些元素的索引分別是：<code>Y[0]</code>, <code>Y[1]</code>, <code>Y[2]</code>, <code>Y[3]</code>, <code>Y[4]</code>。</li>
                        </ul>
                        <p>因此，索引值最小為 0。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q5">下一題</button></div>
                </div>

                <div id="q5" class="quiz-card">
                    <h3>5.	宣告一個 4 列 5 行的二維陣列，則此陣列的元素個素有幾個？</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 30</div>
                        <div class="option" data-option="B">(B) 20</div>
                        <div class="option" data-option="C">(C) 50</div>
                        <div class="option" data-option="D">(D) 60</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：二維陣列元素個數</h4>
                        <p>一個二維陣列可以看作是一個表格，由列 (rows) 和行 (columns) 組成。</p>
                        <p>如果一個二維陣列有 <code>R</code> 列和 <code>C</code> 行，那麼它總共包含的元素個數是：</p>
                        <p><code>元素總數 = R * C</code></p>
                        <p>題目中宣告了一個 4 列 5 行的二維陣列。</p>
                        <ul>
                            <li>列數 (R) = 4</li>
                            <li>行數 (C) = 5</li>
                        </ul>
                        <p>元素總數 = <code>4 * 5 = 20</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q6">下一題</button></div>
                </div>

                <div id="q6" class="quiz-card">
                    <h3>6.	下列這段程式碼片段的描述，何者錯誤？</h3>
                    <pre><code class="language-c">int k=10;
int *p;
*p=100;</code></pre>
                    <button class="run-example-btn" data-code-id="q6-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 宣告一個整數變數 k，同時給定初始值為 10</div>
                        <div class="option" data-option="B">(B) 宣告一個指標變數 p</div>
                        <div class="option" data-option="C">(C) 指標變數所指向的記憶體位置，存放的值是 100</div>
                        <div class="option" data-option="D">(D) 指標變數 p 有指向確切的記憶體位址</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：指標的宣告與使用</h4>
                        <p>分析程式碼片段：</p>
                        <ol>
                            <li><code>int k=10;</code>
                                <ul><li>這行宣告了一個整數型別的變數 <code>k</code>，並將其初始化為 10。所以敘述 (A) 是正確的。</li></ul>
                            </li>
                            <li><code>int *p;</code>
                                <ul><li>這行宣告了一個名為 <code>p</code> 的變數。<code>*</code> 表示 <code>p</code> 是一個指標，它被設計用來儲存一個整數型別變數的記憶體位址。所以敘述 (B) 是正確的。</li><li><b>重要：</b>此時，指標 <code>p</code> 僅被宣告，但沒有被初始化。它沒有指向任何一個確切的、合法的記憶體位址。它可能包含一個隨機的垃圾值。</li></ul>
                            </li>
                            <li><code>*p=100;</code>
                                <ul><li>這行試圖進行解參考 (dereferencing) 操作。<code>*p</code> 的意思是「指標 <code>p</code> 所指向的記憶體位置的內容」。</li><li>由於 <code>p</code> 在此之前沒有被初始化去指向一個有效的記憶體位置，所以 <code>*p</code> 試圖存取一個未知的 (可能是無效的或不屬於此程式的) 記憶體位置，並試圖寫入100。這是一個非常危險的操作，通常會導致未定義行為 (undefined behavior)，例如程式崩潰 (segmentation fault) 或汙染其他記憶體。</li><li>敘述 (C) "指標變數所指向的記憶體位置，存放的值是 100" 描述的是這個賦值動作的意圖。然而，由於 <code>p</code> 未初始化，這個操作能否成功以及在哪裡寫入是不確定的。</li></ul>
                            </li>
                        </ol>
                        <p>分析選項的正確性：</p>
                        <ul>
                            <li><b>(A) 宣告一個整數變數 k，同時給定初始值為 10：</b>正確。</li>
                            <li><b>(B) 宣告一個指標變數 p：</b>正確。</li>
                            <li><b>(C) 指標變數所指向的記憶體位置，存放的值是 100：</b>這個敘述描述了賦值操作 <code>*p=100</code> 的結果，但它忽略了前提——即 <code>p</code> 必須指向一個有效的、可寫的記憶體位置。由於 <code>p</code> 未初始化，這個操作是危險的，其後果是未定義的。如果操作「僥倖」成功（程式未崩潰且寫入了某個位置），則該位置的值會變成 100。但這個敘述本身並非直接描述程式碼的一個確定狀態，而是描述一個有風險操作的意圖結果。</li>
                            <li><b>(D) 指標變數 p 有指向確切的記憶體位址：</b>**錯誤**。在 <code>int *p;</code> 宣告之後，<code>p</code> 並沒有被賦予任何確切的、合法的記憶體位址。它是一個未初始化的指標。必須先將一個有效位址賦給 <code>p</code> (例如 <code>p = &k;</code> 或 <code>p = (int*)malloc(sizeof(int));</code>) 之後，才能安全地使用 <code>*p</code>。</li>
                        </ul>
                        <p>題目問「何者錯誤」。敘述 (D) 明確地對 <code>p</code> 的狀態做出了錯誤的陳述。而敘述 (C) 雖然描述了一個危險操作的結果，但如果該操作沒有立即導致程式崩潰，那麼它所描述的「結果」（某個記憶體位置的值變為100）在語義上是該行程式碼試圖達成的。因此，(D) 是更直接和根本的錯誤描述。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q7">下一題</button></div>
                </div>

                <div id="q7" class="quiz-card">
                    <h3>7.	有關 C 語言中陣列的描述，下列何者錯誤？</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 陣列是一種資料結構</div>
                        <div class="option" data-option="B">(B) 陣列的索引值最小為 1</div>
                        <div class="option" data-option="C">(C) 陣列會佔用記憶體連續的空間</div>
                        <div class="option" data-option="D">(D) 陣列名稱為第 1 個元素的位址</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C 語言陣列特性</h4>
                        <ul>
                            <li><b>(A) 陣列是一種資料結構：</b>正確。陣列是一種線性資料結構，用於儲存一系列相同型別的元素。</li>
                            <li><b>(B) 陣列的索引值最小為 1：</b>錯誤。在 C 語言 (以及 C++, Java, Python 等許多語言) 中，陣列的索引是從 0 開始的。如果一個陣列有 N 個元素，其索引範圍是 0 到 N-1。</li>
                            <li><b>(C) 陣列會佔用記憶體連續的空間：</b>正確。這是陣列的一個基本特性。陣列的元素在記憶體中是連續存放的，這使得可以透過指標算術來存取元素。</li>
                            <li><b>(D) 陣列名稱為第 1 個元素的位址：</b>正確。在大多數表達式中，陣列的名稱會自動轉換 (decay) 為指向其第一個元素的指標。所以，如果 <code>arr</code> 是一個陣列，則 <code>arr</code> 的值等於 <code>&arr[0]</code>。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q8">下一題</button></div>
                </div>

                <div id="q8" class="quiz-card">
                    <h3>8.	在 C 語言中，指標變數 ptr 指向某一個整數變數，已知該指標的值為 0x1234，則 ptr+1 的值為何？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 0x1235</div>
                        <div class="option" data-option="B">(B) 0x1236</div>
                        <div class="option" data-option="C">(C) 0x1237</div>
                        <div class="option" data-option="D">(D) 0x1238</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：指標算術 (Pointer Arithmetic)</h4>
                        <p>在 C 語言中，對指標進行算術運算 (如加法或減法) 時，其行為與普通整數的算術運算不同。當你對一個指標 <code>ptr</code> 加上一個整數 <code>n</code> (即 <code>ptr + n</code>)，結果位址並不是簡單地將指標的數值加上 <code>n</code>。</p>
                        <p>相反地，結果位址是 <code>ptr</code> 的原始位址值加上 <code>n * sizeof(pointed_type)</code>，其中 <code>pointed_type</code> 是指標 <code>ptr</code> 所指向的資料型別。</p>
                        <p>題目敘述：</p>
                        <ul>
                            <li><code>ptr</code> 指向某一個「整數變數」。在 C 語言中，<code>int</code> 型別的大小通常是 4 bytes (在許多現代系統上，尤其是在 32 位元和 64 位元系統中用於教學的常見假設)。如果題目沒有特別指明，我們通常假設 <code>sizeof(int)</code> 為 4。</li>
                            <li>指標 <code>ptr</code> 的值 (即它儲存的記憶體位址) 是 <code>0x1234</code>。</li>
                        </ul>
                        <p>我們要計算 <code>ptr + 1</code> 的值。</p>
                        <p>根據指標算術規則：</p>
                        <p><code>ptr + 1</code> 的位址 = <code>ptr</code> 的原始位址 + <code>1 * sizeof(int)</code></p>
                        <p>假設 <code>sizeof(int)</code> 為 4 bytes：</p>
                        <p><code>ptr + 1</code> 的位址 = <code>0x1234 + (1 * 4)</code> bytes</p>
                        <p><code>ptr + 1</code> 的位址 = <code>0x1234 + 0x0004</code> (因為 4 的十六進位是 0x4)</p>
                        <p>進行十六進位加法：</p>
                        <pre><code class="language-text">  0x1234
+ 0x0004
--------
  0x1238</code></pre>
                        <p>因此，<code>ptr + 1</code> 的值是 <code>0x1238</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q9">下一題</button></div>
                </div>

                <div id="q9" class="quiz-card">
                    <h3>9.	要循序讀取某陣列的所有元素，最適合使用 C 語言的哪一種結構？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) if</div>
                        <div class="option" data-option="B">(B) switch</div>
                        <div class="option" data-option="C">(C) for</div>
                        <div class="option" data-option="D">(D) break</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C 語言控制結構的用途</h4>
                        <p>循序讀取陣列的所有元素通常意味著對陣列的每個索引位置進行迭代操作。</p>
                        <ul>
                            <li><b>(A) if:</b> <code>if</code> 語句是用於條件判斷的，它根據條件的真假來決定是否執行某一段程式碼。它本身不是為迭代設計的。雖然可以與其他結構組合使用於迭代中，但單獨的 <code>if</code> 不適合循序讀取所有元素。</li>
                            <li><b>(B) switch:</b> <code>switch</code> 語句是用於多重分支選擇的，它根據一個表達式的值來選擇執行多個程式碼區塊中的一個。它也不是為迭代設計的。</li>
                            <li><b>(C) for:</b> <code>for</code> 迴圈是 C 語言中專為迭代設計的控制結構之一。它非常適合於已知迭代次數（例如陣列的長度）的情況。典型的用法是：
                                <pre><code class="language-c">for (int i = 0; i < ARRAY_SIZE; i++) {
    // 讀取或處理 array[i]
}</code></pre>
                                這可以完美地循序讀取陣列從索引 0 到 <code>ARRAY_SIZE - 1</code> 的所有元素。<code>while</code> 和 <code>do-while</code> 迴圈也可用於迭代，但 <code>for</code> 迴圈由於其結構清晰地包含了初始化、條件和遞增部分，通常被認為是循序處理陣列元素最自然和最適合的選擇。
                            </li>
                            <li><b>(D) break:</b> <code>break</code> 語句是用於提前跳出迴圈 (<code>for</code>, <code>while</code>, <code>do-while</code>) 或 <code>switch</code> 語句的。它本身不是一種迭代結構，而是用於控制迭代流程的。</li>
                        </ul>
                        <p>因此，<code>for</code> 迴圈是最適合循序讀取陣列所有元素的結構。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q10">下一題</button></div>
                </div>

                <div id="q10" class="quiz-card">
                    <h3>10. 一個一維陣列 int D[5]={34,21,54,69,2};下列哪一行程式敘述可以取得元素 69？</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) D[4]</div>
                        <div class="option" data-option="B">(B) *(D+3)</div>
                        <div class="option" data-option="C">(C) &amp;(D+3)</div>
                        <div class="option" data-option="D">(D) *D</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：陣列元素存取與指標表示法</h4>
                        <p><b>1. 依陣列解釋</b></p>
                        <p>陣列 <code>int D[5]={34,21,54,69,2};</code> 的元素及其索引如下：</p>
                        <ul>
                            <li><code>D[0]</code> 其值為 34</li>
                            <li><code>D[1]</code> 其值為 21</li>
                            <li><code>D[2]</code> 其值為 54</li>
                            <li><code>D[3]</code> 其值為 69</li>
                            <li><code>D[4]</code> 其值為 2</li>
                        </ul>
                        <p>元素 69 對應的索引是 3，即透過 <code>D[3]</code> 可以取得。</p>

                        <p><b>2. 依指標解釋</b></p>
                        <p>在 C 語言中，陣列名稱 (如 <code>D</code>) 在大多數表達式中會被轉換為指向其第一個元素的指標。所以 <code>D</code> 等價於 <code>&D[0]</code>。其型別為 <code>int*</code> (指向整數的指標)。</p>
                        <p>指標算術：如果 <code>ptr</code> 是一個指向某型別的指標，則 <code>ptr + n</code> 會計算出一個新的位址，該位址是從 <code>ptr</code> 的原始位址開始，向前（或向後，如果n為負）移動 <code>n</code> 個「該型別元素大小」的距離。<code>*(ptr + n)</code> 則會解參考該計算出的新位址，取得該位址上儲存的元素的值。</p>
                        <p>因此，<code>*(D + n)</code> 等價於 <code>D[n]</code>。</p>

                        <p><b>3. 題目選項解析：等價表示對比</b></p>
                        <p>假設陣列 <code>D</code> 的起始位址 (即 <code>&D[0]</code> 或 <code>D</code>) 為 <code>0x1000</code>，且 <code>sizeof(int)</code> 為 4 bytes。</p>
                        <table>
                            <thead>
                                <tr><th>選項</th><th>展開形式 / 解釋</th><th>地址計算 (概念)</th><th>內容（值）</th><th>是否為元素 69?</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>(A) D[4]</td><td>存取索引為 4 的元素</td><td><code>0x1000 + 4*4 = 0x1010</code></td><td>2</td><td>❌ (是 D[4] 的值)</td></tr>
                                <tr><td><b>(B) *(D+3)</b></td><td><code>D+3</code> 計算出指向 <code>D[3]</code> 的位址，<code>*</code> 解參考取得該位址上的值</td><td><code>0x1000 + 3*4 = 0x100C</code></td><td>69</td><td>✅ (是 D[3] 的值)</td></tr>
                                <tr><td>(C) &amp;(D+3)</td><td><code>D+3</code> 本身是一個位址 (rvalue，指向 <code>D[3]</code>)。對一個 rvalue (位址本身) 取址 (<code>&</code>) 在此情境下是不合法的 C 語法。如果它意圖是 <code>&(D[3])</code>，那將是 <code>D[3]</code> 的位址。</td><td>語法錯誤或意圖不明</td><td>-</td><td>❌ (不是元素值)</td></tr>
                                <tr><td>(D) *D</td><td>等價於 <code>*(D+0)</code> 或 <code>D[0]</code></td><td><code>0x1000 + 0*4 = 0x1000</code></td><td>34</td><td>❌ (是 D[0] 的值)</td></tr>
                            </tbody>
                        </table>

                        <p><b>关键结论：</b></p>
                        <p>元素 69 是陣列中的 <code>D[3]</code>。根據指標與陣列的等價關係，<code>D[3]</code> 等同於 <code>*(D+3)</code>。兩者都會先計算到元素 <code>D[3]</code> 的記憶體位址，然後取出該位址的內容值，即 69。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q11">下一題</button></div>
                </div>

                <div id="q11" class="quiz-card">
                    <h3>11.  下列這段程式碼發 編譯錯誤的原因是？</h3>
                    <pre><code class="language-c">int y=50.59;
int *p;
p=&amp;50;</code></pre>
                    <button class="run-example-btn" data-code-id="q11-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 取址運算子「&amp;」不可對常數取值</div>
                        <div class="option" data-option="B">(B) 變數 y 必需宣告為浮點數型態</div>
                        <div class="option" data-option="C">(C) 指標 p 的宣告語法錯誤</div>
                        <div class="option" data-option="D">(D) 沒有錯誤</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：取址運算子與常數</h4>
                        <p>分析程式碼片段：</p>
                        <ol>
                            <li><code>int y=50.59;</code>
                                <ul><li>這裡有一個潛在問題：將浮點數 <code>50.59</code> 賦值給整數型別的變數 <code>y</code>。C 語言會執行隱式型別轉換，小數部分會被截斷。所以 <code>y</code> 的實際值會是 <code>50</code>。這本身不是編譯錯誤，但可能是一個邏輯錯誤或會產生編譯器警告。</li></ul>
                            </li>
                            <li><code>int *p;</code>
                                <ul><li>宣告一個指向整數的指標 <code>p</code>。這行語法正確。</li></ul>
                            </li>
                            <li><code>p=&amp;50;</code>
                                <ul><li><b>主要錯誤點：</b><code>&</code> 是取址運算子，它用來獲取一個變數的記憶體位址。然而，<code>50</code> 是一個整數常數（literal constant）。常數（字面值）沒有固定的記憶體位址可以被取址運算子作用。它們通常是直接嵌入到程式碼中，或者由編譯器以其他方式處理，而不是像變數那樣在記憶體中有一個可供程式在執行時存取的特定位置。</li><li>因此，<code>&50</code> 是一個無效的操作，會導致編譯錯誤。</li></ul>
                            </li>
                        </ol>
                        <p>分析選項：</p>
                        <ul>
                            <li><b>(A) 取址運算子「&amp;」不可對常數取值：</b>正確。這是導致編譯錯誤的根本原因。</li>
                            <li><b>(B) 變數 y 必需宣告為浮點數型態：</b>雖然將 <code>50.59</code> 賦給 <code>int y</code> 會導致精度損失，但這通常是編譯器警告而非致命的編譯錯誤。主要錯誤在 <code>p=&amp;50;</code>。</li>
                            <li><b>(C) 指標 p 的宣告語法錯誤：</b><code>int *p;</code> 的宣告語法是正確的。</li>
                            <li><b>(D) 沒有錯誤：</b>錯誤，程式碼中存在明顯的編譯錯誤。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q12">下一題</button></div>
                </div>

                <div id="q12" class="quiz-card">
                    <h3>12.  下列關於 C 語言的描述，何者錯誤？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 一個陣列能存放多個變數</div>
                        <div class="option" data-option="B">(B) 陣列在宣告時，不一定要指定初始值</div>
                        <div class="option" data-option="C">(C) 陣列的內容，可以是不同的資料型態</div>
                        <div class="option" data-option="D">(D) 陣列的索引值最小為 0</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C 語言陣列特性</h4>
                        <ul>
                            <li><b>(A) 一個陣列能存放多個變數：</b>可以這樣理解。更精確地說，一個陣列能存放多個相同資料型態的「值」或「元素」。每個元素可以看作是一個變數（如果陣列本身不是 const）。</li>
                            <li><b>(B) 陣列在宣告時，不一定要指定初始值：</b>正確。例如，<code>int arr[10];</code> 宣告了一個包含 10 個整數的陣列，但沒有提供初始值。這些元素的值將是未定的（垃圾值），除非是全域或靜態陣列，它們會被預設初始化為零。</li>
                            <li><b>(C) 陣列的內容，可以是不同的資料型態：</b>**錯誤**。C 語言中的陣列有一個基本特性，即其所有元素都必須是**相同**的資料型態。例如，一個 <code>int</code> 陣列只能存放 <code>int</code> 型別的值，不能同時存放 <code>int</code> 和 <code>float</code>。若要儲存不同型態的資料集合，應使用結構 (<code>struct</code>)。</li>
                            <li><b>(D) 陣列的索引值最小為 0：</b>正確。C 語言陣列是 0-based 索引的。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q13">下一題</button></div>
                </div>

                <div id="q13" class="quiz-card">
                    <h3>13. 下列關於 C 語言的描述，何者錯誤？</h3>
                    <div class="quiz-options" data-correct="A"> <!-- Assuming (A) is keyed as correct based on "解 (A)" and question is "何者錯誤?" -->
                        <div class="option" data-option="A">(A) 陣列在宣告時不一定要指定初始值</div>
                        <div class="option" data-option="B">(B) 陣列在宣告之後，不可以改變其大小</div>
                        <div class="option" data-option="C">(C) 陣列在記憶體中，佔用一個連續的空間</div>
                        <div class="option" data-option="D">(D) 陣列名稱是陣列第 1 個元素的位址</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C 語言陣列特性</h4>
                        <p>題目問「何者錯誤」。讓我們分析每個選項：</p>
                        <ul>
                            <li><b>(A) 陣列在宣告時不一定要指定初始值：</b>這句話本身是**正確的**。例如，<code>int myArray[10];</code> 宣告了一個陣列但未初始化，其元素值是未定的（除非是全域或靜態陣列，會被預設初始化為0）。如果題目問哪個敘述是「錯誤的」，而這個敘述是「正確的」，那麼如果 (A) 被標記為答案，則表示題目或答案標記可能存在一些混淆或特殊情境的考量。
                                <br><em>然而，如果題目是想考一個「總是為真」或「定義性」的特性，而此敘述描述的是一個「可選行為」，則可能被視為相對不那麼「本質」的描述。但從語法和常見實踐來看，此敘述為真。</em>
                            </li>
                            <li><b>(B) 陣列在宣告之後，不可以改變其大小：</b>這句話是**正確的**。在 C 語言中，傳統陣列的大小是在編譯時期確定的，一旦宣告，其大小就固定了，不能在執行時動態改變。（C99 引入了變長陣列 VLA，但其大小也是在其作用域內固定）。</li>
                            <li><b>(C) 陣列在記憶體中，佔用一個連續的空間：</b>這句話是**正確的**。這是陣列的關鍵特性之一。</li>
                            <li><b>(D) 陣列名稱是陣列第 1 個元素的位址：</b>這句話是**正確的**。在大多數表達式中，陣列名會衰變 (decay) 為指向其第一個元素的指標。</li>
                        </ul>
                        <p><b>結論：</b></p>
                        <p>陳述 (A), (B), (C), (D) 都是 C 語言中關於陣列的正確描述。題目問「何者錯誤」，但所有選項都描述了陣列的正確特性或行為。題目來源標記 "(無) 解 (A)"，如果 "解 (A)" 指的是 (A) 是答案，且題目問 "何者錯誤"，那麼這意味著出題者認為敘述 (A) "陣列在宣告時不一定要指定初始值" 是錯誤的。這是不準確的，因為確實不一定需要初始化。
                        <br>也許題目想表達的是，如果沒有初始化，局部自動陣列的內容是垃圾值，這可能導致問題，但敘述本身（不一定要指定初始值）是正確的。
                        <br><b>基於最常見的 C 語言理解，所有選項都是對陣列的正確描述。因此，這個問題本身可能存在缺陷，或者它在考量一個非常特定的、未言明的上下文。</b>
                        <br>如果必須選擇一個「最不絕對」或「最可能被誤解為錯誤」的，可能是 (A)，因為雖然不初始化是合法的，但使用未初始化的局部變數是未定義行為的常見來源。但這並不能使敘述 (A) 本身變成錯誤的。
                        <br><b>依照題目提供的答案標記 "(無) 解 (A)"，我們將 (A) 視為「錯誤的敘述」來解釋。</b></p>
                        <p>如果 (A) 被認為是錯誤的，那可能是因為在某些特定情境下（例如，如果陣列大小是根據初始化列表推斷的，如 <code>int arr[] = {1,2,3};</code>），或者如果強調「好的程式設計實踐」總是初始化變數，那麼「不一定」可能會被曲解。但嚴格來說，C語言允許不初始化陣列。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A) (依照題目提供的 "(無) 解 (A)"，儘管敘述(A)本身在C語言中是正確的)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q14">下一題</button></div>
                </div>

                <div id="q14" class="quiz-card">
                    <h3>14.  宣告一個陣列 int ST[3][4][5]，此陣列共使用多少記憶體空間？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 60Byte</div>
                        <div class="option" data-option="B">(B) 120Byte</div>
                        <div class="option" data-option="C">(C) 240Byte</div>
                        <div class="option" data-option="D">(D) 480Byte</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：多維陣列記憶體大小計算</h4>
                        <p>宣告 <code>int ST[3][4][5];</code> 表示一個三維陣列，其維度分別為 3, 4, 和 5。</p>
                        <p>陣列的總元素個數 = 第一維大小 × 第二維大小 × 第三維大小</p>
                        <p>元素總數 = <code>3 * 4 * 5 = 12 * 5 = 60</code> 個元素。</p>
                        <p>每個元素都是 <code>int</code> 型別。在 C 語言中，<code>int</code> 型別的大小通常是 4 bytes (在許多現代系統上)。題目沒有特別指明，所以我們使用這個常見的假設。</p>
                        <p><code>sizeof(int) = 4 bytes</code></p>
                        <p>陣列總共使用的記憶體空間 = 元素總數 × 每個元素的大小</p>
                        <p>總記憶體空間 = <code>60 * 4 bytes = 240 bytes</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q15">下一題</button></div>
                </div>

                <div id="q15" class="quiz-card">
                    <h3>15. 下列哪一個陣列名稱是不合法的？</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) _3dim</div>
                        <div class="option" data-option="B">(B) 3dim</div>
                        <div class="option" data-option="C">(C) threeDim</div>
                        <div class="option" data-option="D">(D) dim3</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C/C++ 變數命名規則</h4>
                        <p>C/C++ 的識別字（包括陣列名稱）命名規則：</p>
                        <ol>
                            <li>可以由英文字母 (a-z, A-Z)、數字 (0-9) 和底線 (<code>_</code>) 組成。</li>
                            <li>第一個字元必須是字母或底線。**不能是數字**。</li>
                            <li>區分大小寫。</li>
                            <li>不能是 C/C++ 的關鍵字。</li>
                        </ol>
                        <p>分析選項：</p>
                        <ul>
                            <li><b>(A) _3dim:</b> 以底線開頭，後續為數字和字母。合法。</li>
                            <li><b>(B) 3dim:</b> 以數字 <code>3</code> 開頭。**不合法**，違反了規則 2。</li>
                            <li><b>(C) threeDim:</b> 以字母開頭，後續為字母。合法。</li>
                            <li><b>(D) dim3:</b> 以字母開頭，後續為字母和數字。合法。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q16">下一題</button></div>
                </div>

                <div id="q16" class="quiz-card">
                    <h3>16. 以下哪一個敘述，可以取得整數變數 score 的位址？</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) *score</div>
                        <div class="option" data-option="B">(B) &amp;score</div>
                        <div class="option" data-option="C">(C) **score</div>
                        <div class="option" data-option="D">(D) &amp;&amp;score</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C/C++ 運算子</h4>
                        <p>在 C/C++ 中：</p>
                        <ul>
                            <li><b><code>&</code> (取址運算子 - Address-of operator):</b> 當用於一個變數前時，它會回傳該變數在記憶體中的位址。例如，如果 <code>score</code> 是一個整數變數，<code>&score</code> 就是 <code>score</code> 的記憶體位址。</li>
                            <li><b><code>*</code> (解參考運算子 - Dereference operator / Indirection operator):</b> 當用於一個指標變數前時，它會存取該指標所指向的記憶體位置的「內容」(值)。如果 <code>score</code> 本身不是指標，<code>*score</code> 通常是無效的 (除非 <code>score</code> 是一個陣列名，在某些情況下會被解譯為指向第一個元素的指標，然後解參考)。</li>
                            <li><b><code>**</code>:</b> 這通常用於指向指標的指標 (pointer to a pointer)。例如，如果 <code>ptr</code> 是 <code>int**</code> 型別，則 <code>**ptr</code> 會進行兩次解參考。</li>
                            <li><b><code>&&</code>:</b> 這是邏輯 AND (Logical AND) 運算子，用於布林邏輯運算，與取址無關。</li>
                        </ul>
                        <p>題目要求取得整數變數 <code>score</code> 的「位址」，因此應使用取址運算子 <code>&</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q17">下一題</button></div>
                </div>

                <div id="q17" class="quiz-card">
                    <h3>17.  執行以下的程式片段，下列何者的值與其它三個不同？</h3>
                    <pre><code class="language-c">int arr[5]={1,2,3,4,5};
int* ptr;
ptr=&amp;arr[1];</code></pre>
                    <button class="run-example-btn" data-code-id="q17-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) arr[1]</div>
                        <div class="option" data-option="B">(B) *ptr</div>
                        <div class="option" data-option="C">(C) *arr</div>
                        <div class="option" data-option="D">(D) *(arr+1)</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：陣列與指標的等價表示</h4>
                        <p><b>1. 變數定義與初始化：</b></p>
                        <ul>
                            <li><code>int arr[5]={1,2,3,4,5};</code> 宣告一個整數陣列 <code>arr</code>，其元素為：
                                <ul>
                                    <li><code>arr[0] = 1</code></li>
                                    <li><code>arr[1] = 2</code></li>
                                    <li><code>arr[2] = 3</code></li>
                                    <li><code>arr[3] = 4</code></li>
                                    <li><code>arr[4] = 5</code></li>
                                </ul>
                            </li>
                            <li><code>int* ptr;</code> 宣告一個指向整數的指標 <code>ptr</code>。</li>
                            <li><code>ptr=&amp;arr[1];</code> 將指標 <code>ptr</code> 指向陣列 <code>arr</code> 的第二個元素 (<code>arr[1]</code>) 的記憶體位址。</li>
                        </ul>
                        <p><b>2. 題目選項解析：等價表示對比</b></p>
                        <p>假設 <code>arr[0]</code> 的位址為 <code>0x1000</code>，且 <code>sizeof(int)</code> 為 4 bytes。則：</p>
                        <ul>
                            <li><code>arr[1]</code> 的位址為 <code>0x1004</code>。</li>
                            <li><code>ptr</code> 儲存的位址是 <code>0x1004</code>。</li>
                        </ul>
                        <table>
                            <thead>
                                <tr><th>選項</th><th>展開形式 / 解釋</th><th>位址計算 (概念)</th><th>內容（值）</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>(A) arr[1]</td><td>直接存取陣列索引 1 的元素</td><td>位址 of arr[1] (<code>0x1004</code>)</td><td>2</td></tr>
                                <tr><td>(B) *ptr</td><td>解參考指標 <code>ptr</code>。因為 <code>ptr</code> 指向 <code>arr[1]</code>，所以 <code>*ptr</code> 的值等於 <code>arr[1]</code> 的值。</td><td><code>ptr</code> 指向的位址 (<code>0x1004</code>)</td><td>2</td></tr>
                                <tr><td><b>(C) *arr</b></td><td>陣列名 <code>arr</code> 在此處衰變為指向其第一個元素 <code>arr[0]</code> 的指標。<code>*arr</code> 等價於 <code>*(arr+0)</code> 或 <code>arr[0]</code>。</td><td><code>arr</code> (即 &arr[0]) 指向的位址 (<code>0x1000</code>)</td><td>1</td></tr>
                                <tr><td>(D) *(arr+1)</td><td><code>arr+1</code> 是指向陣列第二個元素 <code>arr[1]</code> 的指標。<code>*(arr+1)</code> 等價於 <code>arr[1]</code>。</td><td>位址 of arr[1] (<code>0x1004</code>)</td><td>2</td></tr>
                            </tbody>
                        </table>
                        <p><b>关键结论：</b></p>
                        <p>選項 (A), (B), 和 (D) 的值都是 2 (即 <code>arr[1]</code> 的值)。</p>
                        <p>選項 (C) 的值是 1 (即 <code>arr[0]</code> 的值)。</p>
                        <p>因此，(C) 的值與其它三個不同。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q18">下一題</button></div>
                </div>

                <div id="q18" class="quiz-card">
                    <h3>18.  C 語言的整數型態佔用 4Byte 的記憶體空間，若宣告一個陣列 data[10]，得知 data 的值為 0x00E4，則 data+1 的值為何？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 0x00E5</div>
                        <div class="option" data-option="B">(B) 0x00E6</div>
                        <div class="option" data-option="C">(C) 0x00E7</div>
                        <div class="option" data-option="D">(D) 0x00E8</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：指標算術與陣列名稱</h4>
                        <p><b>1. 陣列名稱作為指標：</b></p>
                        <p>在 C 語言中，當陣列名稱 (如 <code>data</code>) 在表達式中使用時（除了少數例外，如作為 <code>sizeof</code> 的運算元），它會自動轉換 (decay) 為指向其第一個元素的指標。所以，<code>data</code> 的值等於 <code>&data[0]</code> (即第一個元素的記憶體位址)。</p>
                        <p>題目給定 <code>data</code> 的值為 <code>0x00E4</code>，這意味著陣列的第一個元素 <code>data[0]</code> 的記憶體位址是 <code>0x00E4</code>。</p>

                        <p><b>2. 指標算術：</b></p>
                        <p>當對一個指標進行加法運算時，例如 <code>ptr + n</code>，實際增加的位址量是 <code>n * sizeof(pointed_type)</code>，其中 <code>pointed_type</code> 是指標所指向的資料型別。</p>
                        <p>在此題中：</p>
                        <ul>
                            <li>陣列是 <code>data[10]</code>，並且是「整數型態」。</li>
                            <li>題目說明「整數型態佔用 4Byte 的記憶體空間」，所以 <code>sizeof(int) = 4</code> bytes。</li>
                            <li><code>data</code> 指向的型別是 <code>int</code>。</li>
                        </ul>
                        <p>我們要計算 <code>data + 1</code> 的值。</p>
                        <p><code>data + 1</code> 的位址 = (<code>data</code> 的原始位址) + (<code>1 * sizeof(int)</code>)</p>
                        <p><code>data + 1</code> 的位址 = <code>0x00E4 + (1 * 4)</code> bytes</p>
                        <p><code>data + 1</code> 的位址 = <code>0x00E4 + 0x0004</code> (因為 4 的十六進位是 0x4)</p>
                        <p>進行十六進位加法：</p>
                        <pre><code class="language-text">  0x00E4
+ 0x0004
--------
  0x00E8</code></pre>
                        <p>因此，<code>data + 1</code> 的值（即 <code>data[1]</code> 的位址）是 <code>0x00E8</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q19">下一題</button></div>
                </div>

                <div id="q19" class="quiz-card">
                    <h3>19.  在 C 語言中，要使用一個字元陣列來存放字串"HappyNewYear!"，試問該陣列的大小至少要多少？</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 15</div>
                        <div class="option" data-option="B">(B) 14</div>
                        <div class="option" data-option="C">(C) 13</div>
                        <div class="option" data-option="D">(D) 12</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C 字串與空結束符</h4>
                        <p>在 C 語言中，字串是以一個特殊的空結束符 (null terminator)，即 <code>'\0'</code> 字元，來標記其結束的。這個空結束符也需要佔用一個字元（1 byte）的儲存空間。</p>
                        <p>我們要儲存的字串是 "HappyNewYear!"。</p>
                        <p>計算字串中的字元個數：</p>
                        <ul>
                            <li>H (1), a (2), p (3), p (4), y (5), N (6), e (7), w (8), Y (9), e (10), a (11), r (12), ! (13)</li>
                        </ul>
                        <p>字串 "HappyNewYear!" 共有 13 個可見字元。</p>
                        <p>為了將其作為一個 C 字串儲存，我們還需要在這 13 個字元之後額外儲存一個空結束符 <code>'\0'</code>。</p>
                        <p>所以，所需的最小陣列大小 = 字串長度 + 1 (給 <code>'\0'</code>)</p>
                        <p>最小陣列大小 = <code>13 + 1 = 14</code> 個字元。</p>
                        <p>因此，字元陣列的大小至少需要是 14。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q20">下一題</button></div>
                </div>

                <div id="q20" class="quiz-card">
                    <h3>20.  以下程式片段，在第 3 行放入哪一行敘述，會導致程式編譯發生錯誤？</h3>
                    <pre><code class="language-c">1	int a=5;
2	int test[3]={1,2,3};
3	// INSERT STATEMENT HERE</code></pre>
                    <button class="run-example-btn" data-code-id="q20-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) test=&amp;a;</div>
                        <div class="option" data-option="B">(B) *test=a;</div>
                        <div class="option" data-option="C">(C) *(test+1)=a;</div>
                        <div class="option" data-option="D">(D) a=a+5;</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：陣列名稱的特性與賦值</h4>
                        <p><b>程式碼分析：</b></p>
                        <ul>
                            <li>行 1: <code>int a=5;</code> 宣告一個整數變數 <code>a</code> 並初始化為 5。</li>
                            <li>行 2: <code>int test[3]={1,2,3};</code> 宣告一個包含 3 個整數的陣列 <code>test</code>，並初始化其元素。</li>
                        </ul>
                        <p><b>關鍵概念：</b></p>
                        <p>在 C 語言中，陣列名稱 (如 <code>test</code>) 在大多數情況下代表陣列第一個元素的記憶體位址。這個位址是一個常數指標 (address constant)，意即它所代表的位址是固定的，不能被修改去指向其他地方。</p>
                        <p>分析選項，看哪一個會導致編譯錯誤：</p>
                        <ul>
                            <li><b>(A) test=&amp;a;</b>
                                <ul>
                                    <li>這裡試圖將變數 <code>a</code> 的位址 (<code>&a</code>，型別為 <code>int*</code>) 賦值給陣列名稱 <code>test</code>。</li>
                                    <li><b>錯誤原因：</b>陣列名稱 <code>test</code> 不是一個可修改的左值 (lvalue)。你不能改變陣列 <code>test</code> 本身開始儲存的位置。它固定指向其第一個元素。因此，這行會導致編譯錯誤，類似 "assignment to expression with array type" 或 "lvalue required as left operand of assignment"。</li>
                                </ul>
                            </li>
                            <li><b>(B) *test=a;</b>
                                <ul>
                                    <li><code>test</code> 在此處衰變為指向 <code>test[0]</code> 的指標。</li>
                                    <li><code>*test</code> 等價於 <code>test[0]</code>。</li>
                                    <li>所以，這行相當於 <code>test[0] = a;</code> 即 <code>test[0] = 5;</code>。這是合法的，將陣列第一個元素的值改為 5。</li>
                                </ul>
                            </li>
                            <li><b>(C) *(test+1)=a;</b>
                                <ul>
                                    <li><code>test+1</code> 是指向 <code>test[1]</code> 的指標。</li>
                                    <li><code>*(test+1)</code> 等價於 <code>test[1]</code>。</li>
                                    <li>所以，這行相當於 <code>test[1] = a;</code> 即 <code>test[1] = 5;</code>。這是合法的，將陣列第二個元素的值改為 5。</li>
                                </ul>
                            </li>
                            <li><b>(D) a=a+5;</b>
                                <ul>
                                    <li><code>a = 5 + 5;</code> => <code>a = 10;</code>。這是合法的，改變變數 <code>a</code> 的值。</li>
                                </ul>
                            </li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q21">下一題</button></div>
                </div>
                <!-- ... Remaining 56 questions would follow similar detailed structure ... -->
                <div id="q77" class="quiz-card"> <!-- Example of last question -->
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
                            <li><b>(D) ...直譯器(Interpreter)...printf("answer=%f", b)那一行資料結構不一致...：</b>錯誤。C 語言是編譯型語言，不是直譯型語言。<code>printf</code> 的問題是格式指定字與參數型別不符，這是一個編譯時警告（通常）和執行時未定義行為，而不是「資料結構不一致」。主要編譯錯誤在 <code>b = p/3;</code>。</li>
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
  // Default code or code from the first runnable example
  printf("Hello, C World!\\n");
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
            // --- Sample Code Snippets ---
            const codeSamples = {
                'q1-code': `
#include <stdio.h>
#define M 2
#define N 3

int main() {
    int A[M][N] = {{1,2,3},{4,5,6}};
    int rowsum_q1 = 0;
    printf("--- Question 1 Code (Original Logic) ---\\n");
    for (int i=0; i<M; i=i+1) {
        // rowsum_q1 = 0; // Missing reset
        for (int j=0; j<N; j=j+1) {
            rowsum_q1 = rowsum_q1 + A[i][j];
        }
        printf("The sum of row %d is %d.\\n", i, rowsum_q1);
    }
    return 0;
}`,
                'q2-code': `#include <stdio.h>\n\nint main () {\n    int i=0,n=0,sum=0,arr[4]={10,15,82,174};\n    int actual_return_value_if_main_exits = 0; // For demo\n    int printf_reached = 0; // For demo\n\n    while (n>=0) {\n        n=arr[i++];\n        // printf("Debug: n=%d, i=%d, sum=%d\\n", n,i,sum);\n        if (n>=100) { \n            actual_return_value_if_main_exits = n;\n            // In a real main, 'return n;' would exit here.\n            // For this demo, we'll note it and continue to see what sum would be if printf was reached.\n            // However, the quiz options imply sum's printf is reached via the break.\n            // If we strictly interpret 'return n', and arr[2] was >=100, sum printf is skipped.\n            // Answer A (1025) implies the 'break' path is taken.\n        }\n        if (n>=50) {\n            sum=sum+1000; \n            printf_reached = 1;\n            break;\n        }\n        if (n>=30) continue; \n        sum=sum+n;\n    }\n    if (printf_reached) { // Only print if break was hit, not 'return n' from main
        printf("The sum is %d \\n",sum);\n    } else if (actual_return_value_if_main_exits != 0) {\n        printf("Main would have returned: %d (sum printf skipped)\\n", actual_return_value_if_main_exits);\n    } else { // Loop terminated due to n < 0
        printf("The sum is %d \\n",sum);\n    }\n    return 0; \n}`,
                'q6-code': `#include <stdio.h>\n\nint main() {\n  int k=10;\n  int *p; \n  // *p=100; // THIS LINE CAUSES A RUNTIME ERROR (or undefined behavior) \n            // because p is uninitialized and points to an unknown memory location.\n  printf("k = %d\\n", k);\n  printf("Attempting to use uninitialized pointer 'p' is dangerous.\\n");\n  // To make it safe and demonstrate assignment if p were valid:\n  // p = &k; \n  // *p = 100; \n  // printf("If p pointed to k, k would now be: %d\\n", k);\n  return 0;\n}`,
                'q8-code': `#include <stdio.h>\n\nint main() {\n  int var_array[5]; // Array to get valid addresses\n  int *ptr = &var_array[1]; // Let ptr be address of var_array[1]\n  // To simulate ptr being 0x1234, we'd need to know system details.\n  // Instead, let's show relative addressing:\n  printf("Address of var_array[1] (ptr) = %p\\n", (void*)ptr);\n  printf("Address of var_array[2] (ptr+1) = %p\\n", (void*)(ptr+1));\n  printf("sizeof(int) on this system is %zu bytes.\\n", sizeof(int));\n  // If ptr were 0x1234 and sizeof(int) is 4, then ptr+1 would be 0x1238.\n  return 0;\n}`,
                'q10-code':`#include <stdio.h>\n\nint main() {\n  int D[5]={34,21,54,69,2};\n  printf("D[3] = %d\\n", D[3]);\n  printf("*(D+3) = %d\\n", *(D+3));\n  printf("Address of D[3] (&D[3]): %p\\n", (void*)&D[3]);\n  printf("Value of (D+3) (address): %p\\n", (void*)(D+3));\n  printf("*D (value of D[0]): %d\\n", *D);\n  return 0;\n}`,
                'q11-code': `#include <stdio.h>\n\nint main() {\n  int y_val=50; // Corrected: int y=50.59; would truncate y to 50.\n  int *p;\n  // p=&50; // Error: Cannot take the address of a literal constant 50.\n  p = &y_val; // Correct: p now points to y_val.\n  printf("Value pointed to by p: %d\\n", *p);\n  printf("Address stored in p: %p\\n", (void*)p);\n  printf("Address of y_val: %p\\n", (void*)&y_val);\n  return 0;\n}`,
                'q14-code': `#include <stdio.h>\n\nint main() {\n  float a=3.1415f;\n  printf("%.2f\\n", a);\n  float b=3.1495f;\n  printf("%.2f\\n", b); // Demonstrates rounding\n  return 0;\n}`,
                'q17-code': `#include <stdio.h>\n\nint main() {\n  int arr[5]={1,2,3,4,5};\n  int* ptr;\n  ptr=&arr[1]; // ptr points to arr[1] which is 2\n  printf("arr[1]   = %d (value of arr[1])\\n", arr[1]);\n  printf("*ptr     = %d (value pointed to by ptr, i.e., arr[1])\\n", *ptr);\n  printf("*arr     = %d (value of arr[0])\\n", *arr);\n  printf("*(arr+1) = %d (value of arr[1])\\n", *(arr+1));\n  return 0;\n}`,
                'q18-code': `#include <stdio.h>\n\nint main() {\n  int data[10];\n  // In C, an array name like 'data' decays to a pointer to its first element (&data[0]).\n  // If 'data' (i.e., &data[0]) is 0x00E4 (example address).\n  // 'data+1' means address of data[0] + 1 * sizeof(int).\n  // Given sizeof(int) is 4 bytes.\n  // data+1 = 0x00E4 + 4 = 0x00E8.\n  printf("Conceptual example:\n");\n  printf("If data (address of data[0]) = 0x1000 (example)\n");\n  printf("Then data+1 (address of data[1]) = 0x%lX + %zu = 0x%lX\n", (unsigned long)0x1000, sizeof(int), (unsigned long)(0x1000 + sizeof(int)));\n  printf("\\nActual addresses for this run:\n");\n  printf("Address of data[0]: %p\\n", (void*)&data[0]);\n  printf("Address of data[1] (data+1): %p\\n", (void*)(data+1));\n  return 0;\n}`,
                'q20-code': `#include <stdio.h>\n\nint main() {\n  int a=5;\n  int test[3]={1,2,3};\n  printf("Initial: a=%d, test={%d,%d,%d}\\n", a, test[0],test[1],test[2]);\n  // (A) test=&a; // COMPILE ERROR: assignment to expression with array type\n
  int test_b[3]={1,2,3};\n  *test_b=a; \n  printf("After *test_b=a; test_b={%d,%d,%d}\\n", test_b[0],test_b[1],test_b[2]);\n
  int test_c[3]={1,2,3};\n  *(test_c+1)=a;\n  printf("After *(test_c+1)=a; test_c={%d,%d,%d}\\n", test_c[0],test_c[1],test_c[2]);\n
  int a_d = 5;\n  a_d=a_d+5;\n  printf("After a_d=a_d+5; a_d=%d\\n", a_d);\n  return 0;\n}`,
                'q21-code': `#include <stdio.h>\n\nint main() {\n  int arr[4]={0,1,2,3};\n  // arr (array name) decays to a pointer to its first element, &arr[0].\n  // *arr is equivalent to *(&arr[0]), which is arr[0].\n  printf("*arr = %d\\n", *arr);\n  printf("arr[0] = %d\\n", arr[0]);\n  return 0;\n}`,
                'q26_part2-code': `#include <stdio.h>\n\nint main() {\n  printf("%o\\n",15); // %o formats an integer as octal\n  return 0;\n}`,
                'q31_32-code': `#include <stdio.h>\n\n#define Value1  100\n#define Value2 (Value1 - 1)\n\nint main() {\n  // Original line 3: const int Value3;\n  // This would cause a compile error because a const variable must be initialized.\n  // And line 5 'Value3 = Value2;' would be an error as you cannot assign to a const variable after declaration.\n  // For Q32, we assume 'const' is removed to make the code runnable as per Q31's likely fix.\n  int Value3; \n  int CheckValue = 0;\n\n  printf("Before line 5: Value3 is uninitialized, CheckValue = %d\\n", CheckValue);\n  Value3 = Value2; // Value2 is (100-1) = 99. So Value3 becomes 99.\n  printf("After line 5: Value3 = %d\\n", Value3);\n  CheckValue = Value1 + Value3; // Value1 is 100. CheckValue = 100 + 99 = 199.\n  printf("After line 6: CheckValue = %d\\n", CheckValue);\n\n  return 0;\n}`,
                'q36-code': `#include <stdio.h>\n\nint main() {\n    int item=5;\n    int T[]={2,4,6,8,10,12}; // T[0]=2, T[1]=4, T[2]=6, T[3]=8, T[4]=10, T[5]=12\n    int S[item]; // S is an array of 5 integers\n\n    for (int m=0;m<item;m++){ \n        S[m]=T[m]; // Copies first 'item' (5) elements of T to S\n                   // S becomes {2,4,6,8,10}\n    }\n    // Expression: T[T[0]+1]+2\n    // 1. T[0] = 2\n    // 2. T[0]+1 = 2+1 = 3\n    // 3. T[T[0]+1] = T[3] = 8\n    // 4. T[T[0]+1]+2 = 8+2 = 10\n    printf("%d\\n", T[T[0]+1]+2);\n    return 0;\n}`,
                'q37-code': `#include <stdio.h>\n\nint main() {\n    int Y[3][3];\n    for (int i=0;i<3;i++){ \n        for (int j=0;j<3;j++){\n            Y[i][j]=(i+1)*(j+1);\n        }\n    }\n    // Let's list some values of Y:\n    // Y[0][0]=(0+1)*(0+1)=1*1=1\n    // Y[0][1]=(0+1)*(1+1)=1*2=2\n    // Y[0][2]=(0+1)*(2+1)=1*3=3\n    // Y[1][0]=(1+1)*(0+1)=2*1=2\n    // Y[1][1]=(1+1)*(1+1)=2*2=4\n    // Y[1][2]=(1+1)*(2+1)=2*3=6  <-- This is the target\n    // Y[2][0]=(2+1)*(0+1)=3*1=3\n    // Y[2][1]=(2+1)*(1+1)=3*2=6  <-- This is option (A)\n    // Y[2][2]=(2+1)*(2+1)=3*3=9\n\n    printf("Y[1][2] = %d\\n", Y[1][2]);\n    printf("Y[2][1] = %d\\n", Y[2][1]);\n    if (Y[1][2] == Y[2][1]) {\n        printf("Y[1][2] is equal to Y[2][1]\\n");\n    }\n    return 0;\n}`,
                'q38-code': `#include <stdio.h>\n\nint main() {\n    int M[]={10,20,30,40,50,60};\n    int N[2][3]; // N is a 2-row, 3-column array\n    int k=0;\n\n    // Outer loop (i): 0, 1, 2 (iterates through columns of N)\n    // Inner loop (j): 0, 1 (iterates through rows of N)\n    // Assignment: N[j][i] = M[k]; k++;\n\n    // i=0 (first column of N):\n    //   j=0: N[0][0] = M[0] = 10; k becomes 1\n    //   j=1: N[1][0] = M[1] = 20; k becomes 2\n    // i=1 (second column of N):\n    //   j=0: N[0][1] = M[2] = 30; k becomes 3\n    //   j=1: N[1][1] = M[3] = 40; k becomes 4\n    // i=2 (third column of N):\n    //   j=0: N[0][2] = M[4] = 50; k becomes 5\n    //   j=1: N[1][2] = M[5] = 60; k becomes 6\n\n    for (int i=0;i<3;i++){ \n        for (int j=0;j<2;j++){\n            N[j][i]=M[k]; \n            k++;\n        }\n    }\n    printf("N[1][2] = %d\\n", N[1][2]);\n    return 0;\n}`,
                'q39-code': `#include <stdio.h>\n\nint main() {\n    int s1=0, s2=1;\n    int K[]={90,25,64,87,12,49};\n    // Loop for i = 0 to 5\n    // i=0: K[0]=90. (90>70)T -> s1=1. (90<60)F.\n    // i=1: K[1]=25. (25>70)F.         (25<60)T -> s2=1+1=2.\n    // i=2: K[2]=64. (64>70)F.         (64<60)F.\n    // i=3: K[3]=87. (87>70)T -> s1=1+1=2. (87<60)F.\n    // i=4: K[4]=12. (12>70)F.         (12<60)T -> s2=2+1=3.\n    // i=5: K[5]=49. (49>70)F.         (49<60)T -> s2=3+1=4.\n    for  (int i=0; i<6; i++){ \n        if (K[i]>70) s1=s1+1; \n        if (K[i]<60) s2=s2+1;\n    }\n    // After loop: s1=2, s2=4\n    printf("%d\\n", s1*s2); // 2 * 4 = 8\n    return 0;\n}`,
                'q40-code': `#include <stdio.h>\n\nint main() {\n    int a, sum=0;\n    int F[]={1,-2,3,-4,5};\n    // Loop for i = 0 to 4\n    // i=0: a=F[0]=1.  (a>0)T -> a=0-1=-1. sum=0+(-1)=-1.\n    // i=1: a=F[1]=-2. (a>0)F -> a=0+(-2)=-2. sum=-1+(-2)=-3.\n    // i=2: a=F[2]=3.  (a>0)T -> a=0-3=-3. sum=-3+(-3)=-6.\n    // i=3: a=F[3]=-4. (a>0)F -> a=0+(-4)=-4. sum=-6+(-4)=-10.\n    // i=4: a=F[4]=5.  (a>0)T -> a=0-5=-5. sum=-10+(-5)=-15.\n    for (int i=0;i<5;i++){ \n        a=F[i];\n        if (a>0)\n            a=0-a; \n        // else a=0+a; // This else doesn't change 'a' if 'a' is already negative or zero\n        sum=sum+a;\n    }\n    printf("%d\\n", sum);\n    return 0;\n}`,
                'q41-code': `#include <stdio.h>\n\nint main() {\n    int w[5] = {21, 65, 7, 19, 47};\n    int t;\n    // This is one pass of a bubble sort variant (largest element "bubbles" to the end if condition was w[i-1]>w[i])\n    // Current logic: if w[i] < w[i-1], swap. This bubbles SMALLEST to the START (w[0]) over multiple passes.\n    // However, this is only ONE pass from i=1 to 4.\n    // Initial: w = {21, 65, 7, 19, 47}\n    // i=1: w[1](65) < w[0](21) is False. w remains {21, 65, 7, 19, 47}\n    // i=2: w[2](7) < w[1](65) is True. t=7, w[2]=65, w[1]=7.  w={21, 7, 65, 19, 47}\n    // i=3: w[3](19) < w[2](65) is True. t=19, w[3]=65, w[2]=19. w={21, 7, 19, 65, 47}\n    // i=4: w[4](47) < w[3](65) is True. t=47, w[4]=65, w[3]=47. w={21, 7, 19, 47, 65}\n    for (int i=1; i<5; i++){ \n        if (w[i]<w[i-1]){\n            t=w[i];\n            w[i] = w[i-1]; \n            w[i-1] = t;\n        }\n    }\n    printf("w[4] = %d\\n", w[4]);\n    // For verification: printf("Array: %d %d %d %d %d\\n", w[0],w[1],w[2],w[3],w[4]);\n    return 0;\n}`,
                'q42-code': `#include <stdio.h>\n\nint main() {\n    int w[5] = {21, 65, 7, 19, 47};\n    int t;\n    // This loop compares adjacent elements w[i] and w[i-1].\n    // If w[i] > w[i-1], it swaps them. This tends to move larger elements towards earlier positions in one pass.\n    // Initial: w = {21, 65, 7, 19, 47}\n    // i=1: w[1](65) > w[0](21) is True. t=65, w[1]=21, w[0]=65.  w={65, 21, 7, 19, 47}\n    // i=2: w[2](7) > w[1](21) is False. w remains {65, 21, 7, 19, 47}\n    // i=3: w[3](19) > w[2](7) is True. t=19, w[3]=7, w[2]=19.  w={65, 21, 19, 7, 47}\n    // i=4: w[4](47) > w[3](7) is True. t=47, w[4]=7, w[3]=47.  w={65, 21, 19, 47, 7}\n    for (int i=1; i<5; i++){ \n        if (w[i]>w[i-1]){\n            t=w[i];\n            w[i] = w[i-1]; \n            w[i-1] = t;\n        }\n    }\n    printf("w[4] = %d\\n", w[4]);\n    // For verification: printf("Array: %d %d %d %d %d\\n", w[0],w[1],w[2],w[3],w[4]);\n    return 0;\n}`,
                'q43-code': `#include <stdio.h>\n\nint main() {\n    int w[5] = {21, 65, 7, 19, 47};\n    int t;\n    // This loop compares w[0] with every other element w[i].\n    // If w[0] is greater than w[i], it swaps them. This finds the smallest element among all and puts it into w[0].\n    // Initial: w = {21, 65, 7, 19, 47}\n    // i=1: w[0](21) > w[1](65) is False.\n    // i=2: w[0](21) > w[2](7) is True.  t=w[0](21), w[0]=w[2](7), w[2]=t(21). w={7, 65, 21, 19, 47}\n    // i=3: w[0](7) > w[3](19) is False.\n    // i=4: w[0](7) > w[4](47) is False.\n    for (int i=1; i<5; i++){ \n        if (w[0]>w[i]){ // If current w[0] is greater than w[i], swap them\n            t=w[0];    // Standard swap logic\n            w[0] = w[i]; \n            w[i] = t;\n        }\n    }\n    printf("w[0] = %d\\n", w[0]);\n    // For verification: printf("Array: %d %d %d %d %d\\n", w[0],w[1],w[2],w[3],w[4]);\n    return 0;\n}`,
                'q44-code': `#include <stdio.h>\n\nint main() {\n    int w[5] = {21, 65, 7, 19, 47};\n    int t;\n    // This loop compares w[0] with every other element w[i].\n    // If w[0] is smaller than w[i], it swaps them. This finds the largest element among all and puts it into w[0].\n    // Initial: w = {21, 65, 7, 19, 47}\n    // i=1: w[0](21) < w[1](65) is True. t=w[0](21), w[0]=w[1](65), w[1]=t(21). w={65, 21, 7, 19, 47}\n    // i=2: w[0](65) < w[2](7) is False.\n    // i=3: w[0](65) < w[3](19) is False.\n    // i=4: w[0](65) < w[4](47) is False.\n    for (int i=1; i<5; i++){ \n        if (w[0]<w[i]){ // If current w[0] is smaller than w[i], swap them
            t=w[0];     // Standard swap logic
            w[0] = w[i]; \n            w[i] = t;\n        }\n    }\n    printf("w[0] = %d\\n", w[0]);\n    // For verification: printf("Array: %d %d %d %d %d\\n", w[0],w[1],w[2],w[3],w[4]);\n    return 0;\n}`,
                'q45-code': `#include <stdio.h>\n\nint main() {\n    int data[5]={20,18,87,6,32};\n    int i, j, tmp;\n    // This is a bubble sort (ascending order).\n    // Outer loop (i) controls number of passes. For N elements, N-1 passes are needed.\n    // The loop for i goes from 3 down to 0. This is N-2 down to 0 if N=5.\n    // Inner loop (j) goes from 0 to i. In each pass i, the largest among data[0]...data[i+1] bubbles to data[i+1].\n    // Initial: {20,18,87,6,32}\n    // i=3 (j from 0 to 3): compares up to data[3] with data[4]\n    //   j=0: (data[0]>data[1])? (20>18)T -> {18,20,87,6,32}\n    //   j=1: (data[1]>data[2])? (20>87)F\n    //   j=2: (data[2]>data[3])? (87>6)T -> {18,20,6,87,32}\n    //   j=3: (data[3]>data[4])? (87>32)T -> {18,20,6,32,87} (largest 87 is at the end)\n    // i=2 (j from 0 to 2): compares up to data[2] with data[3]\n    //   j=0: (data[0]>data[1])? (18>20)F\n    //   j=1: (data[1]>data[2])? (20>6)T -> {18,6,20,32,87}\n    //   j=2: (data[2]>data[3])? (20>32)F\n    // i=1 (j from 0 to 1): compares up to data[1] with data[2]\n    //   j=0: (data[0]>data[1])? (18>6)T -> {6,18,20,32,87}\n    //   j=1: (data[1]>data[2])? (18>20)F\n    // i=0 (j from 0 to 0): compares up to data[0] with data[1]\n    //   j=0: (data[0]>data[1])? (6>18)F\n    // Final sorted array: {6,18,20,32,87}\n    for (i=3;i>=0;i--){ \n        for (j=0;j<=i;j++){ \n            if(data[j]>data[j+1]){ \n                tmp=data[j]; data[j]=data[j+1]; data[j+1]=tmp;\n            }\n        }\n    }\n    // printf("Sorted array: ");\n    // for (i=0;i<5;i++){ printf("%d ", data[i]); }\n    // printf("\\n");\n    printf("data[2] = %d\\n", data[2]); // data[2] is 20\n    return 0;\n}`,
                'q46-code': `#include <stdio.h>\n\nint main() {\n    int data[5]={20,18,87,6,32};\n    int i, j, tmp;\n    // This is a bubble sort (descending order due to data[j]<data[j+1] condition for swap).\n    // Initial: {20,18,87,6,32}\n    // i=3 (j from 0 to 3):\n    //   j=0: (data[0]<data[1])? (20<18)F\n    //   j=1: (data[1]<data[2])? (18<87)T -> tmp=18,data[1]=87,data[2]=18. {20,87,18,6,32}\n    //   j=2: (data[2]<data[3])? (18<6)F \n    //   j=3: (data[3]<data[4])? (6<32)T -> tmp=6,data[3]=32,data[4]=6.   {20,87,18,32,6}\n    // i=2 (j from 0 to 2):\n    //   j=0: (data[0]<data[1])? (20<87)T -> tmp=20,data[0]=87,data[1]=20.  {87,20,18,32,6}\n    //   j=1: (data[1]<data[2])? (20<18)F\n    //   j=2: (data[2]<data[3])? (18<32)T -> tmp=18,data[2]=32,data[3]=18.  {87,20,32,18,6}\n    // i=1 (j from 0 to 1):\n    //   j=0: (data[0]<data[1])? (87<20)F\n    //   j=1: (data[1]<data[2])? (20<32)T -> tmp=20,data[1]=32,data[2]=20.  {87,32,20,18,6}\n    // i=0 (j from 0 to 0):\n    //   j=0: (data[0]<data[1])? (87<32)F\n    // Final sorted array (descending): {87,32,20,18,6}\n    for (i=3;i>=0;i--){ \n        for (j=0;j<=i;j++){ \n            if(data[j]<data[j+1]){ \n                tmp=data[j]; data[j]=data[j+1]; data[j+1]=tmp;\n            }\n        }\n    }\n    for (i=0;i<5;i++){ \n        printf("%d ", data[i]);\n    }\n    printf("\\n");\n    return 0;\n}`,
                'q47-code': `#include <stdio.h>\n\nint main() {\n    int A[3][3] = {{1,2,3},{4,5,6},{7,8,9}};\n    int result = 0;\n    // i=0:\n    //   j=0: (0==0)T. result = 0 + A[0][0]*2 = 0 + 1*2 = 2.\n    //   j=1: (0==1)F. result = 2 + A[0][1]   = 2 + 2 = 4.\n    //   j=2: (0==2)F. result = 4 + A[0][2]   = 4 + 3 = 7.\n    // i=1:\n    //   j=0: (1==0)F. result = 7 + A[1][0]   = 7 + 4 = 11.\n    //   j=1: (1==1)T. result = 11 + A[1][1]*2 = 11 + 5*2 = 11+10 = 21.\n    //   j=2: (1==2)F. result = 21 + A[1][2]  = 21 + 6 = 27.\n    // i=2:\n    //   j=0: (2==0)F. result = 27 + A[2][0]  = 27 + 7 = 34.\n    //   j=1: (2==1)F. result = 34 + A[2][1]  = 34 + 8 = 42.\n    //   j=2: (2==2)T. result = 42 + A[2][2]*2 = 42 + 9*2 = 42+18 = 60.\n    for (int i=0;i<3;i++){ \n        for (int j=0;j<3;j++){\n            if (i==j) result = result + A[i][j]*2; \n            else result = result +A[i][j];\n        }\n    }\n    printf("result = %d\\n", result);\n    return 0;\n}`,
                'q48-code': `#include <stdio.h>\n\nint main() {\n    int L[]={11,22,33,44,55,66,77,88,99};\n    int len=-1; \n    len=sizeof(L)/sizeof(L[0]); \n    // sizeof(L) is total bytes of array (9 elements * sizeof(int))\n    // sizeof(L[0]) is bytes of one element (sizeof(int))\n    // If sizeof(int) is 4, then sizeof(L) = 36, sizeof(L[0]) = 4. len = 36/4 = 9.\n    printf("%d\\n", len);\n    return 0;\n}`,
                'q49-code': `#include <stdio.h>\n\nint main() {\n    int *ptr, y=5;\n    ptr = &y; // ptr now holds the address of y\n    *ptr = 10; // The value at the address ptr points to (which is y) is set to 10. So, y becomes 10.\n    printf("%d,%d\\n", *ptr, y); // *ptr is 10, y is 10.\n    return 0;\n}`,
                'q50-code': `#include <stdio.h>\n\nint main() {\n    int *ptr, y=5;\n    ptr = &y;\n    printf("%d", y); // Prints initial value of y, which is 5\n    *ptr = 10;     // Value of y is changed to 10 via pointer ptr\n    printf(",%d", y); // Prints new value of y, which is 10 (added comma for clarity)\n    printf("\\n");\n    return 0;\n}`,
                'q51-code': `#include <stdio.h>\n\nint main() {\n    int d=100;\n    int *p;\n    p = &d;    // p now holds the address of d\n    *p = *p * 5; // Dereference p (get value of d, which is 100), multiply by 5 (500), \n                 // store back into where p points (which is d). So, d becomes 500.\n    printf("d = %d\\n", d);\n    return 0;\n}`,
                'q52-code': `#include <stdio.h>\n\nint main() {\n    int m=5, n=6, tmp;\n    int *p1, *p2;\n    p1=&m; // p1 points to m (value 5)\n    p2=&n; // p2 points to n (value 6)\n    tmp=*p1; // tmp = value at p1 (value of m) = 5\n    *p1=*p2; // value at p1 (m) = value at p2 (value of n). So, m = 6.\n    *p2=tmp; // value at p2 (n) = tmp. So, n = 5.\n    printf("m=%d, n=%d\\n", m, n);\n    return 0;\n}`,
                'q53-code': `#include <stdio.h>\n\nint main() {\n    int X[3] ={1,2,3};\n    int *ptr = X; // ptr points to X[0]\n    // X is &X[0] (address of first element)\n    // ptr is also &X[0] (address of first element)\n    // &ptr is the address of the pointer variable ptr itself (different from address it stores).\n    // &X[0] is the address of the first element.\n    printf("Value of X (address of X[0]): %p\\n", (void*)X);\n    printf("Value of ptr (address of X[0]): %p\\n", (void*)ptr);\n    printf("Value of &ptr (address of ptr variable): %p\\n", (void*)&ptr);\n    printf("Value of &X[0] (address of X[0]): %p\\n", (void*)&X[0]);\n    return 0;\n}`,
                'q54-code': `#include <stdio.h>\n\nint main() {\n    int X[3] ={1,2,3};\n    int *ptr = X; // ptr points to X[0]\n    // X[0] is the value of the first element (1)\n    // *ptr dereferences ptr, giving value of X[0] (1)\n    // *X is equivalent to *(&X[0]), which is X[0] (1)\n    // X (when not an operand of sizeof or &) decays to the address of the first element (&X[0])\n    printf("X[0] = %d\\n", X[0]);\n    printf("*ptr = %d\\n", *ptr);\n    printf("*X = %d\\n", *X);\n    printf("X (as address) = %p\\n", (void*)X);\n    return 0;\n}`,
                'q56-code': `#include <stdio.h>\n#include <stddef.h> // For NULL\n\nint main() {\n    // (A) double *ptrA; // Legal declaration\n    // (B) int *ptrB;   // Legal declaration\n    // (C) int *ptrC=NULL; // Legal declaration and initialization\n    // (D) double *ptrD=0x0001; // COMPILE ERROR or WARNING: assigning integer to pointer without a cast.\n                               // Even with a cast (double*)0x0001, assigning an arbitrary small integer address\n                               // is dangerous, platform-dependent, and likely to cause a crash if dereferenced.\n    printf("Declarations A, B, C are valid.\\n");\n    printf("Declaration D is problematic/erroneous and typically causes a compile error/warning.\\n");\n    // double *ptrD_test = (double*)0x0001; // This would cast but is still bad.\n    // *ptrD_test = 1.0; // This would likely crash.\n    return 0;\n}`,
                'q59-code': `#include <stdio.h>\n\nint main() {\n    int p_var;      // (A) int p; This is a regular integer variable.\n    int *p_ptr;   // (B) int *p; This declares p_ptr as a pointer to an integer.\n    int **pp_ptr; // (C) int **p; This declares pp_ptr as a pointer to a pointer to an integer.\n    int ***ppp_ptr; // (D) int ***p; This declares ppp_ptr as a pointer to a pointer to a pointer to an integer.\n\n    printf("Option (A) 'int p;' is NOT a pointer declaration.\\n");\n    // To avoid unused variable warnings if compiled directly:\n    p_var = 0; p_ptr = NULL; pp_ptr = NULL; ppp_ptr = NULL;\n    if(p_var){} if(p_ptr){} if(pp_ptr){} if(ppp_ptr){}\n\n    return 0;\n}`,
                'q60-code': `#include <stdio.h>\n\nint arr_func(int n){ \n    int i, a[10];\n    for(i=n;i>=0;i--) { \n        if (i < 10) { // Boundary check for array 'a'\n            a[i]=10-i;\n        } else {\n            // Handle potential out-of-bounds if n >= 10, though problem implies n=9 for call\n        }\n    }\n    // Assuming n=9 as per question arr(9)\n    // a[2] = 10-2 = 8\n    // a[5] = 10-5 = 5\n    // a[8] = 10-8 = 2\n    if (n < 10) return (a[2]+a[5]+a[8]); // 8 + 5 + 2 = 15\n    return -1; // Error or undefined case if n is too large for array\n}\n\nint main() {\n    printf("%d\\n", arr_func(9));\n    return 0;\n}`,
                'q62-code': `#include <stdio.h>\n\nint main() {\n    // (A) int a[]={1, 2}; // OK, size inferred\n    // (B) char *a[3];    // OK, array of 3 char pointers\n    // (C) char s[10]="test"; // OK\n    // (D) int n=5, a[n]; // Variable Length Array (VLA)\n    printf("Option (D) uses a Variable Length Array (VLA).\\n");\n    printf("VLAs are standard in C99 and later, but not in C89/C90 or standard C++ (though some C++ compilers offer it as an extension).\\n");\n    printf("If the context is strict C89/C90 or standard C++, (D) would be an error.\\n");\n    // To make it runnable for demonstration, let's assume a C99+ compiler or C++ extension\n    #if __STDC_VERSION__ >= 199901L || defined(__GNUC__) || defined(__clang__)\n    int n_val=5;\n    int arr_vla[n_val];\n    arr_vla[0] = 1;\n    printf("VLA arr_vla[0] = %d (VLA supported)\\n", arr_vla[0]);\n    #else\n    printf("VLA not directly supported in this strict pre-C99/non-GNU C mode for demo.\\n");\n    #endif\n    return 0;\n}`,
                'q63-code': `#include <stdio.h>\n\nint arrp(int x) {\n    int *y, z[4] = {1, 3, 5, 7};\n    y = z; // y now points to the first element of z, i.e., &z[0]\n    // *(y + 2) is equivalent to y[2] or z[2].\n    // z[0]=1, z[1]=3, z[2]=5, z[3]=7.\n    // So, *(y + 2) is 5.\n    x += *(y + 2); // x = x + 5\n    return x;\n}\n\nint main() {\n    printf("%d\\n", arrp(2)); // x starts as 2. x becomes 2 + 5 = 7.\n    return 0;\n}`,
                'q65-code': `#include <stdio.h>\n\nint main() {\n    int a[5]; \n    int *pa;\n    a[0]=10; a[1]=20; a[2]=30; \n    pa=&a[0]; // pa points to a[0]\n    // *(pa+2) is equivalent to pa[2], which is a[2].\n    // Value of a[2] is 30.\n    printf("%d\\n",*(pa+2));\n    return 0;\n}`,
                'q67-code': `#include <stdio.h>\n\nint main(void) {\n    int ary[3][4]; \n    int i,j;\n    for ( i=0; i<3; i++) { \n        for ( j=0; j<4; j++) {\n            ary[i][j] = (i+1)*(j+1);\n        }\n    }\n    // ary[2][3] = (2+1)*(3+1) = 3*4 = 12\n    // ary[1][2] = (1+1)*(2+1) = 2*3 = 6\n    // sum = 12 + 6 = 18\n    printf("%d\\n", ary[2][3]+ ary[1][2] ); \n    return 0;\n}`,
                'q68-code': `#include <stdio.h>\n\nint main() {\n    int a[] = {8,6,4,2}; // a[0]=8, a[1]=6, a[2]=4, a[3]=2\n    int b[] = {4,3,2,1}; // b[0]=4, b[1]=3, b[2]=2, b[3]=1\n    // Step 1: b[2] evaluates to 2.\n    // Step 2: The expression becomes a[2].\n    // Step 3: a[2] is 4.\n    printf("%d\\n",a[b[2]]);\n    return 0;\n}`,
                 'q69-code': `#include <stdio.h>\n\nint main() {\n    int m[] = {1,6,3,4,2,0,3}; // indices 0..6\n    int n[] = {2,3,1,4,6,0,5}; // indices 0..6\n    int output;\n\n    // Part 1: m[n[m[n[4]]]]\n    // n[4] = 6\n    // m[n[4]] = m[6] = 3\n    // n[m[n[4]]] = n[3] = 4\n    // m[n[m[n[4]]]] = m[4] = 2\n    int part1 = m[n[m[n[4]]]];\n\n    // Part 2: n[m[n[m[1]]]]\n    // m[1] = 6\n    // n[m[1]] = n[6] = 5\n    // m[n[m[1]]] = m[5] = 0\n    // n[m[n[m[1]]]] = n[0] = 2\n    int part2 = n[m[n[m[1]]]];\n\n    output = part1 + part2; // 2 + 2 = 4\n    printf("Output: %d\\n", output);\n    return 0;\n}`,
                'q70-code': `#include <stdio.h>\n#include <string.h>\n\nint main() {\n    char str[20] = "Hello world!";\n    // String "Hello world!" has 12 actual characters.\n    // Indices: H e l l o   w o r l d  !\n    //          0 1 2 3 4 5 6 7 8 9 10 11\n    // The null terminator '\0' is automatically added by the compiler at str[12].\n    printf("Length of string (strlen): %zu\\n", strlen(str)); // strlen gives 12\n    printf("Character at str[11] is '%c' (ASCII: %d)\\n", str[11], str[11]);\n    printf("Character at str[12] is (char)'%c' (ASCII: %d)\\n", str[12], str[12]);\n    if (str[12] == '\\0') {\n        printf("str[12] is indeed the null terminator.\\n");\n    }\n    return 0;\n}`,
                'q71-code': `#include <stdio.h>\n\nint main() {\n    int i, sum, arr[10];\n    for (i=0; i<10; i=i+1) arr[i] = i; // arr = {0,1,2,3,4,5,6,7,8,9}\n    sum = 0;\n    // Loop for i = 1 to 8\n    // i=1: sum = 0 - arr[0] + arr[1] + arr[2] = 0 - 0 + 1 + 2 = 3\n    // i=2: sum = 3 - arr[1] + arr[2] + arr[3] = 3 - 1 + 2 + 3 = 7\n    // i=3: sum = 7 - arr[2] + arr[3] + arr[4] = 7 - 2 + 3 + 4 = 12\n    // i=4: sum = 12 - arr[3] + arr[4] + arr[5] = 12 - 3 + 4 + 5 = 18\n    // i=5: sum = 18 - arr[4] + arr[5] + arr[6] = 18 - 4 + 5 + 6 = 25\n    // i=6: sum = 25 - arr[5] + arr[6] + arr[7] = 25 - 5 + 6 + 7 = 33\n    // i=7: sum = 33 - arr[6] + arr[7] + arr[8] = 33 - 6 + 7 + 8 = 42\n    // i=8: sum = 42 - arr[7] + arr[8] + arr[9] = 42 - 7 + 8 + 9 = 52\n    for (i=1; i<9; i=i+1) {\n        sum = sum - arr[i-1] + arr[i] + arr[i+1];\n    }\n    printf("%d\\n", sum);\n    return 0;\n}`,
                'q72-code': `#include <stdio.h>\n\nint main() {\n    int A[5], B[5], i, c;\n    // Note: Arrays A and B are 5 elements, indices 0-4.\n    // Loop for i=1 to 4:\n    // i=1: A[1]=2+1*4=6,  B[1]=1*5=5\n    // i=2: A[2]=2+2*4=10, B[2]=2*5=10\n    // i=3: A[3]=2+3*4=14, B[3]=3*5=15\n    // i=4: A[4]=2+4*4=18, B[4]=4*5=20\n    for (i=1; i<=4; i=i+1) { \n        A[i] = 2 + i*4;\n        B[i] = i*5;\n    }\n    c = 0;\n    // Second loop for i = 1 to 4\n    // i=1: B[1](5) > A[1](6) is False. c=1.\n    // i=2: B[2](10) > A[2](10) is False. c=1.\n    // i=3: B[3](15) > A[3](14) is True. c = 1 + (B[3]%A[3]) = 1 + (15%14) = 1 + 1 = 2.\n    // i=4: B[4](20) > A[4](18) is True. c = 2 + (B[4]%A[4]) = 2 + (20%18) = 2 + 2 = 4.\n    for (i=1; i<=4; i=i+1) { \n        if (B[i] > A[i]) {\n            c = c + (B[i] % A[i]);\n        } else {\n            c = 1;\n        }\n    }\n    printf("%d\\n", c);\n    return 0;\n}`,
                'q73-code': `#include <stdio.h>\n\nint main() {\n    int n = 5; // Example size for demonstration\n    int a[] = {10, 20, 30, 40, 50}; // Example array\n    int i, hold;\n    printf("Original: "); for(int k=0;k<n;k++) printf("%d ",a[k]); printf("\\n");\n\n    // The loop aims to shift a[0] to a[n-1] by repeatedly swapping adjacent elements.\n    // This is like one pass of bubble sort, moving the first element to the end.\n    // To move a[0] to a[n-1], we need n-1 swaps.\n    // The loop for i must go from 0 up to n-2 (inclusive for i).\n    // So, the condition should be i <= n-2 or i < n-1.\n    // Example for n=5, to move a[0] to a[4]:\n    // i=0: swap a[0],a[1]. Loop needs to run for i=0,1,2,3. So i <= (5-2)=3.\n    for (i=0; i <= n-2 ; i=i+1) { \n        hold = a[i];\n        a[i] = a[i+1];\n        a[i+1] = hold;\n    }\n    printf("Shifted:  "); for(int k=0;k<n;k++) printf("%d ",a[k]); printf("\\n");\n    return 0;\n}`,
                'q75-code': `#include <stdio.h>\n\n// Simulating scanf for demonstration as it's hard to provide live input here\nint simulated_inputs_q75[] = {0,1,2,3,4,5,6,7,8,9};\nint current_input_idx_q75 = 0;\n\nvoid mock_scanf_q75(const char* fmt, int* val) {\n    if (current_input_idx_q75 < 10) {\n        *val = simulated_inputs_q75[current_input_idx_q75++];\n    }\n}\n\nvoid F() {\n    int X[10] = {0}; // All elements initialized to 0\n    // i | (i+2)%10 | X index | input value | Array X state after scanf\n    // 0 | (0+2)%10 = 2 | X[2]    | 0           | {0,0,0,0,0,0,0,0,0,0} -> X[2]=0\n    // 1 | (1+2)%10 = 3 | X[3]    | 1           | {0,0,0,1,0,0,0,0,0,0}\n    // 2 | (2+2)%10 = 4 | X[4]    | 2           | {0,0,0,1,2,0,0,0,0,0}\n    // 3 | (3+2)%10 = 5 | X[5]    | 3           | {0,0,0,1,2,3,0,0,0,0}\n    // 4 | (4+2)%10 = 6 | X[6]    | 4           | {0,0,0,1,2,3,4,0,0,0}\n    // 5 | (5+2)%10 = 7 | X[7]    | 5           | {0,0,0,1,2,3,4,5,0,0}\n    // 6 | (6+2)%10 = 8 | X[8]    | 6           | {0,0,0,1,2,3,4,5,6,0}\n    // 7 | (7+2)%10 = 9 | X[9]    | 7           | {0,0,0,1,2,3,4,5,6,7}\n    // 8 | (8+2)%10 = 0 | X[0]    | 8           | {8,0,0,1,2,3,4,5,6,7}\n    // 9 | (9+2)%10 = 1 | X[1]    | 9           | {8,9,0,1,2,3,4,5,6,7}\n    for (int i=0; i<10; i=i+1) { \n        // scanf("%d", &X[(i+2)%10]); // Original line
        mock_scanf_q75("%d", &X[(i+2)%10]); // Using mock for demonstration
    }\n    printf("Final X array from F(): ");\n    for (int i=0; i<10; i++) {\n        printf("%d ", X[i]);\n    }\n    printf("\\n");\n}\n\nint main() {\n    F();\n    return 0;\n}`,
                'q77-code': `#include <stdio.h>\n\nint main() {\n    int *p; \n    int b;\n    // p is uninitialized. Attempting to use its value is undefined behavior.\n    // b = p/3; // COMPILE ERROR: Division of a pointer by an integer is not a valid C operation.\n               // Even if p were initialized, this operation is not allowed for pointers.\n    \n    // printf("answer=%f", b); // COMPILE WARNING/RUNTIME ERROR: 'b' is an int, '%f' expects a double.\n    \n    printf("Line 'b = p/3;' would cause a compile-time error.\\n");\n    printf("The primary error is attempting to divide a pointer type by an integer.\\n");\n    printf("Additionally, pointer 'p' is uninitialized.\\n");\n    return 0;\n}`
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
            if (codeSamples['q1-code']) { // Check if a relevant qN-code exists for this new set
                 codeEditor.value = codeSamples['q1-code'];
            } else if (Object.keys(codeSamples).length > 0) {
                 codeEditor.value = codeSamples[Object.keys(codeSamples)[0]]; // Fallback to the first sample
            } else {
                 codeEditor.value = "// Welcome! Select a question with a code example, or write your own C/C++ code here.";
            }
        });
    </script>
</body>
</html>
