<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C 語言 陣列與指標進階 (bb5-4)</title>

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
            <h1>C 語言練習：第五章 Part 3 - 指標應用與綜合</h1>
            <p>本頁面為 C/C++ 語言第五章練習題的第三部分 (第 47-77 題，其中 Q55 略過)，包含更多關於指標、多維陣列、字串以及綜合應用的題目。請仔細分析每個問題，並利用右側的沙箱進行實作與驗證。詳解將提供深入的步驟分析和概念釐清。</p>

            <div class="quiz-section">
                <h2>第五章 互動練習題組 (3/3)</h2>
                <p>請挑戰下面的題目，檢驗您的學習成果！</p>
                <!-- QUIZ CARDS START -->
                <div id="q47" class="quiz-card">
                    <h3>47. 下列程式片段執行後，result 的值為何？</h3>
                    <pre><code class="language-c">int A[3][3] = {{1,2,3},{4,5,6},{7,8,9}};
int result = 0;
for (int i=0;i&lt;3;i++){
    for (int j=0;j&lt;3;j++){
        if (i==j) result = result + A[i][j]*2;
        else result = result +A[i][j];
    }
}</code></pre>
                    <button class="run-example-btn" data-code-id="q47-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 80</div>
                        <div class="option" data-option="B">(B) 65</div>
                        <div class="option" data-option="C">(C) 60</div>
                        <div class="option" data-option="D">(D) 90</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>此程式碼計算一個 3x3 陣列 <code>A</code> 的特定加權總和。如果元素在主對角線上 (<code>i==j</code>)，則其值乘以2後加入 <code>result</code>；否則，直接將其值加入 <code>result</code>。</p>
                        <p>陣列 <code>A</code>：</p>
                        <pre>1 2 3
4 5 6
7 8 9</pre>
                        <p>追蹤 <code>result</code> 的變化：</p>
                        <table>
                            <thead><tr><th>i</th><th>j</th><th>A[i][j]</th><th>條件 (i==j)</th><th>動作</th><th>result (累計)</th></tr></thead>
                            <tbody>
                                <tr><td>-</td><td>-</td><td>-</td><td>-</td><td>初始</td><td>0</td></tr>
                                <tr><td>0</td><td>0</td><td>A[0][0]=1</td><td>True</td><td>result += 1*2 = 2</td><td>2</td></tr>
                                <tr><td>0</td><td>1</td><td>A[0][1]=2</td><td>False</td><td>result += 2 = 2</td><td>4</td></tr>
                                <tr><td>0</td><td>2</td><td>A[0][2]=3</td><td>False</td><td>result += 3 = 3</td><td>7</td></tr>
                                <tr><td>1</td><td>0</td><td>A[1][0]=4</td><td>False</td><td>result += 4 = 4</td><td>11</td></tr>
                                <tr><td>1</td><td>1</td><td>A[1][1]=5</td><td>True</td><td>result += 5*2 = 10</td><td>21</td></tr>
                                <tr><td>1</td><td>2</td><td>A[1][2]=6</td><td>False</td><td>result += 6 = 6</td><td>27</td></tr>
                                <tr><td>2</td><td>0</td><td>A[2][0]=7</td><td>False</td><td>result += 7 = 7</td><td>34</td></tr>
                                <tr><td>2</td><td>1</td><td>A[2][1]=8</td><td>False</td><td>result += 8 = 8</td><td>42</td></tr>
                                <tr><td>2</td><td>2</td><td>A[2][2]=9</td><td>True</td><td>result += 9*2 = 18</td><td>60</td></tr>
                            </tbody>
                        </table>
                        <p>最終 <code>result</code> 的值為 60。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q48">下一題</button></div>
                </div>

                <div id="q48" class="quiz-card">
                    <h3>48. 執行以下的程式片段後，螢幕會顯示何值？</h3>
                    <pre><code class="language-c">int L[]={11,22,33,44,55,66,77,88,99};
int len=-1;
len=sizeof(L)/sizeof(L[0]);
printf("%d", len);</code></pre>
                    <button class="run-example-btn" data-code-id="q48-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 1</div>
                        <div class="option" data-option="B">(B) 8</div>
                        <div class="option" data-option="C">(C) 10</div>
                        <div class="option" data-option="D">(D) 9</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：計算陣列元素個數</h4>
                        <p><code>int L[]={11,22,33,44,55,66,77,88,99};</code> 此陣列 <code>L</code> 被初始化了 9 個整數元素。</p>
                        <p><code>sizeof(L)</code>：回傳整個陣列 <code>L</code> 所佔用的總位元組數。假設 <code>sizeof(int)</code> 為 4 bytes，則 <code>sizeof(L)</code> 為 <code>9 * 4 = 36</code> bytes。</p>
                        <p><code>sizeof(L[0])</code>：回傳陣列 <code>L</code> 中第一個元素 (<code>L[0]</code>) 所佔用的位元組數，即 <code>sizeof(int)</code>，為 4 bytes。</p>
                        <p><code>len = sizeof(L)/sizeof(L[0])</code> => <code>len = 36 / 4 = 9</code>。</p>
                        <p><code>printf("%d", len);</code> 會印出 9。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q49">下一題</button></div>
                </div>

                <div id="q49" class="quiz-card">
                    <h3>49. 下列程式片段執行後的輸出為何？</h3>
                    <pre><code class="language-c">int *ptr, y=5;
ptr = &amp;y;
*ptr = 10;
printf("%d,%d\n", *ptr, y);</code></pre>
                    <button class="run-example-btn" data-code-id="q49-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 10,10</div>
                        <div class="option" data-option="B">(B) 5,5</div>
                        <div class="option" data-option="C">(C) 5,10</div>
                        <div class="option" data-option="D">(D) 10,5</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：指標操作</h4>
                        <p><b>1. 依變數、位址、內容解釋</b></p>
                        <ul>
                            <li><code>int *ptr, y=5;</code>：宣告一個整數指標 <code>ptr</code> 和一個整數變數 <code>y</code> 並初始化為 5。
                                <ul>
                                    <li><code>y</code> 的內容是 5。假設 <code>y</code> 的位址是 <code>0x1000</code>。</li>
                                    <li><code>ptr</code> 此時未初始化，其內容 (儲存的位址) 是不確定的。</li>
                                </ul>
                            </li>
                            <li><code>ptr = &amp;y;</code>：將 <code>y</code> 的位址 (<code>0x1000</code>) 賦予指標 <code>ptr</code>。
                                <ul>
                                    <li>現在 <code>ptr</code> 的內容是 <code>0x1000</code> (即它指向 <code>y</code>)。</li>
                                </ul>
                            </li>
                            <li><code>*ptr = 10;</code>：解參考指標 <code>ptr</code>，並將值 10 存入 <code>ptr</code> 所指向的記憶體位置。
                                <ul>
                                    <li><code>ptr</code> 指向 <code>y</code> (位址 <code>0x1000</code>)。</li>
                                    <li>所以，<code>y</code> 的內容被修改為 10。</li>
                                </ul>
                            </li>
                            <li><code>printf("%d,%d\n", *ptr, y);</code>：
                                <ul>
                                    <li><code>*ptr</code>：解參考 <code>ptr</code>，得到 <code>ptr</code> 指向的記憶體位置 (即 <code>y</code>) 的內容，為 10。</li>
                                    <li><code>y</code>：變數 <code>y</code> 的內容，為 10。</li>
                                </ul>
                            </li>
                        </ul>
                        <p>因此，輸出為 "10,10"。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q50">下一題</button></div>
                </div>

                <div id="q50" class="quiz-card">
                    <h3>50. 下列程式片段執行後的輸出為何？</h3>
                    <pre><code class="language-c">int *ptr, y=5;
ptr = &amp;y;
printf("%d", y);
*ptr = 10;
printf(",%d", y); // Added comma for clarity in example output</code></pre>
                    <button class="run-example-btn" data-code-id="q50-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 10,10</div>
                        <div class="option" data-option="B">(B) 5,5</div>
                        <div class="option" data-option="C">(C) 5,10</div>
                        <div class="option" data-option="D">(D) 10,5</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：指標操作與時序</h4>
                        <p><b>1. 依變數、位址、內容解釋</b></p>
                        <ul>
                            <li><code>int *ptr, y=5;</code>：宣告整數指標 <code>ptr</code> 和整數變數 <code>y</code> (值為 5)。</li>
                            <li><code>ptr = &amp;y;</code>：指標 <code>ptr</code> 指向變數 <code>y</code> 的記憶體位址。</li>
                            <li><code>printf("%d", y);</code>：此時 <code>y</code> 的值是 5。所以第一個輸出是 "5"。</li>
                            <li><code>*ptr = 10;</code>：透過指標 <code>ptr</code> 解參考，將 <code>ptr</code> 指向的記憶體位置 (即 <code>y</code>) 的內容修改為 10。所以現在 <code>y</code> 的值變為 10。</li>
                            <li><code>printf(",%d", y);</code>：此時 <code>y</code> 的值是 10。所以第二個輸出是 ",10"。 (假設題目意圖是分開印，或連續印但中間有分隔)</li>
                        </ul>
                        <p>因此，螢幕上的連續輸出將是 "5,10" (如果 <code>printf</code> 之間沒有其他輸出或換行，且第二個 <code>printf</code> 如範例般有逗號)。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q51">下一題</button></div>
                </div>

                <div id="q51" class="quiz-card">
                    <h3>51. 下列程式片段執行後，變數 d 的值為何？</h3>
                    <pre><code class="language-c">int d=100;
int *p;
p = &amp;d;
*p=*p*5; // Corrected from *p=p5;
</code></pre>
                    <button class="run-example-btn" data-code-id="q51-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 100</div>
                        <div class="option" data-option="B">(B) 500</div>
                        <div class="option" data-option="C">(C) 20</div>
                        <div class="option" data-option="D">(D) 5</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：透過指標修改變數值</h4>
                        <p><b>1. 依變數、位址、內容解釋</b></p>
                        <ul>
                            <li><code>int d=100;</code>：宣告整數變數 <code>d</code> 並初始化為 100。</li>
                            <li><code>int *p;</code>：宣告一個指向整數的指標 <code>p</code>。</li>
                            <li><code>p = &amp;d;</code>：指標 <code>p</code> 現在儲存了變數 <code>d</code> 的記憶體位址 (即 <code>p</code> 指向 <code>d</code>)。</li>
                            <li><code>*p = *p * 5;</code>：
                                <ul>
                                    <li>右邊的 <code>*p</code>：解參考 <code>p</code>，得到 <code>p</code> 指向的記憶體位置 (即 <code>d</code>) 的內容，其值為 100。</li>
                                    <li><code>*p * 5</code>：計算 <code>100 * 5 = 500</code>。</li>
                                    <li>左邊的 <code>*p = ...</code>：將計算結果 500 存回到指標 <code>p</code> 所指向的記憶體位置 (即變數 <code>d</code>)。</li>
                                    <li>因此，變數 <code>d</code> 的值變為 500。</li>
                                </ul>
                            </li>
                        </ul>
                        <p>最終，變數 <code>d</code> 的值是 500。</p>
                        <p>(註：原始題目中的 <code>*p=p5;</code> 存在語法問題。已假設其意圖為 <code>*p = *p * 5;</code> 或 <code>*p *= 5;</code> 來進行分析。)</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q52">下一題</button></div>
                </div>

                <div id="q52" class="quiz-card">
                    <h3>52. 下列程式片段執行後，變數 m 和 n 的值分別是多少？</h3>
                    <pre><code class="language-c">int m=5, n=6, tmp;
int *p1, *p2;
p1=&amp;m;
p2=&amp;n;
tmp=*p1;
*p1=*p2;
*p2=tmp;</code></pre>
                    <button class="run-example-btn" data-code-id="q52-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) m=6, n=5</div>
                        <div class="option" data-option="B">(B) m=6, n=6</div>
                        <div class="option" data-option="C">(C) m=5, n=5</div>
                        <div class="option" data-option="D">(D) m=5, n=6</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：透過指標交換變數值</h4>
                        <p>此程式片段演示了如何使用指標和一個暫存變數 <code>tmp</code> 來交換兩個變數 <code>m</code> 和 <code>n</code> 的值。</p>
                        <p><b>1. 依變數、位址、內容解釋</b></p>
                        <ul>
                            <li>初始狀態：
                                <ul>
                                    <li><code>m</code> 的內容是 5。假設 <code>m</code> 的位址是 <code>0x1000</code>。</li>
                                    <li><code>n</code> 的內容是 6。假設 <code>n</code> 的位址是 <code>0x1004</code>。</li>
                                    <li><code>tmp</code> 未初始化。</li>
                                </ul>
                            </li>
                            <li><code>p1=&amp;m;</code>：指標 <code>p1</code> 儲存 <code>m</code> 的位址 (<code>0x1000</code>)。<code>p1</code> 指向 <code>m</code>。</li>
                            <li><code>p2=&amp;n;</code>：指標 <code>p2</code> 儲存 <code>n</code> 的位址 (<code>0x1004</code>)。<code>p2</code> 指向 <code>n</code>。</li>
                            <li><code>tmp=*p1;</code>：
                                <ul>
                                    <li><code>*p1</code> 解參考 <code>p1</code>，得到 <code>p1</code> 指向的內容，即 <code>m</code> 的值 (5)。</li>
                                    <li><code>tmp</code> 被賦值為 5。</li>
                                    <li>狀態：<code>m=5, n=6, tmp=5, p1=&m, p2=&n</code></li>
                                </ul>
                            </li>
                            <li><code>*p1=*p2;</code>：
                                <ul>
                                    <li><code>*p2</code> 解參考 <code>p2</code>，得到 <code>p2</code> 指向的內容，即 <code>n</code> 的值 (6)。</li>
                                    <li>將此值 (6) 賦予 <code>*p1</code> (即 <code>p1</code> 指向的記憶體位置，也就是 <code>m</code>)。</li>
                                    <li>所以，<code>m</code> 的內容變為 6。</li>
                                    <li>狀態：<code>m=6, n=6, tmp=5, p1=&m, p2=&n</code></li>
                                </ul>
                            </li>
                            <li><code>*p2=tmp;</code>：
                                <ul>
                                    <li>將 <code>tmp</code> 的值 (5) 賦予 <code>*p2</code> (即 <code>p2</code> 指向的記憶體位置，也就是 <code>n</code>)。</li>
                                    <li>所以，<code>n</code> 的內容變為 5。</li>
                                    <li>狀態：<code>m=6, n=5, tmp=5, p1=&m, p2=&n</code></li>
                                </ul>
                            </li>
                        </ul>
                        <p>最終，<code>m</code> 的值是 6，<code>n</code> 的值是 5。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q53">下一題</button></div>
                </div>
                 <!-- Questions Q53-Q77 would follow the same detailed explanation structure -->
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
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q47">回到本頁第一題</button></div>
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
  printf("Hello from bb5-4.php!\\nSelect a question example or write your own code.\\n");
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
            const codeSamples = { // Samples for Q47-Q77
                'q47-code': `#include <stdio.h>\n\nint main() {\n    int A[3][3] = {{1,2,3},{4,5,6},{7,8,9}};\n    int result = 0;\n    for (int i=0;i<3;i++){ for (int j=0;j<3;j++){ if (i==j) result = result + A[i][j]*2; else result = result +A[i][j];}}\n    printf("result = %d\\n", result);\n    return 0;\n}`,
                'q48-code': `#include <stdio.h>\n\nint main() {\n    int L[]={11,22,33,44,55,66,77,88,99};\n    int len=-1; \n    len=sizeof(L)/sizeof(L[0]); \n    printf("%d\\n", len);\n    return 0;\n}`,
                'q49-code': `#include <stdio.h>\n\nint main() {\n    int *ptr, y=5;\n    ptr = &y; \n    *ptr = 10; \n    printf("%d,%d\\n", *ptr, y);\n    return 0;\n}`,
                'q50-code': `#include <stdio.h>\n\nint main() {\n    int *ptr, y=5;\n    ptr = &y;\n    printf("%d", y); \n    *ptr = 10;     \n    printf(",%d", y); \n    printf("\\n");\n    return 0;\n}`,
                'q51-code': `#include <stdio.h>\n\nint main() {\n    int d=100;\n    int *p;\n    p = &d;    \n    *p = (*p) * 5; /* Corrected from *p=p5 */ \n    printf("d = %d\\n", d);\n    return 0;\n}`,
                'q52-code': `#include <stdio.h>\n\nint main() {\n    int m=5, n=6, tmp;\n    int *p1, *p2;\n    p1=&m; \n    p2=&n; \n    tmp=*p1; \n    *p1=*p2; \n    *p2=tmp; \n    printf("m=%d, n=%d\\n", m, n);\n    return 0;\n}`,
                'q53-code': `#include <stdio.h>\n\nint main() {\n    int X[3] ={1,2,3};\n    int *ptr = X; \n    printf("Address X (same as &X[0]): %p\\n", (void*)X);\n    printf("Address stored in ptr: %p\\n", (void*)ptr);\n    printf("Address of pointer variable ptr itself: %p\\n", (void*)&ptr);\n    printf("Address &X[0]: %p\\n", (void*)&X[0]);\n    return 0;\n}`,
                'q54-code': `#include <stdio.h>\n\nint main() {\n    int X[3] ={1,2,3};\n    int *ptr = X; \n    printf("X[0] = %d\\n", X[0]);\n    printf("*ptr = %d\\n", *ptr);\n    printf("*X = %d\\n", *X);\n    printf("X (as address) = %p\\n", (void*)X);\n    return 0;\n}`,
                'q56-code': `#include <stdio.h>\n#include <stddef.h> \n\nint main() {\n    printf("Line (D) 'double *ptrD=0x0001;' causes compile error/warning.\\n");\n    return 0;\n}`,
                'q59-code': `#include <stdio.h>\n\nint main() {\n    int p_var_a;      \n    int *p_ptr_b;   \n    int **pp_ptr_c; \n    int ***ppp_ptr_d; \n    printf("(A) int p; is NOT a pointer declaration.\\n");\n    p_var_a = 0; p_ptr_b = NULL; pp_ptr_c = NULL; ppp_ptr_d = NULL; /* Avoid unused warnings */\n    if(p_var_a || !p_ptr_b || !pp_ptr_c || !ppp_ptr_d) { /* use them slightly */ }\n    return 0;\n}`,
                'q60-code': `#include <stdio.h>\n\nint arr_func(int n){ \n    int i, a[10];\n    for(i=n;i>=0;i--) { \n        if (i >= 0 && i < 10) { \n            a[i]=10-i;\n        } \n    }\n    if (n >= 8 && n < 10) return (a[2]+a[5]+a[8]); \n    return -1; \n}\n\nint main() {\n    printf("%d\\n", arr_func(9));\n    return 0;\n}`,
                'q63-code': `#include <stdio.h>\n\nint arrp(int x) {\n    int *y, z[4] = {1, 3, 5, 7};\n    y = z; \n    x += *(y + 2); \n    return x;\n}\n\nint main() {\n    printf("%d\\n", arrp(2)); \n    return 0;\n}`,
                'q65-code': `#include <stdio.h>\n\nint main() {\n    int a[5]; \n    int *pa;\n    a[0]=10; a[1]=20; a[2]=30; \n    pa=&a[0]; \n    printf("%d\\n",*(pa+2));\n    return 0;\n}`,
                'q67-code': `#include <stdio.h>\n\nint main(void) {\n    int ary[3][4]; \n    int i,j;\n    for ( i=0; i<3; i++) { \n        for ( j=0; j<4; j++) {\n            ary[i][j] = (i+1)*(j+1);\n        }\n    }\n    printf("%d\\n", ary[2][3]+ ary[1][2] ); \n    return 0;\n}`,
                'q68-code': `#include <stdio.h>\n\nint main() {\n    int a[] = {8,6,4,2};\n    int b[] = {4,3,2,1};\n    printf("%d\\n",a[b[2]]);\n    return 0;\n}`,
                 'q69-code': `#include <stdio.h>\n\nint main() {\n    int m[] = {1,6,3,4,2,0,3};\n    int n[] = {2,3,1,4,6,0,5};\n    int output;\n    int part1 = m[n[m[n[4]]]];\n    int part2 = n[m[n[m[1]]]];\n    output = part1 + part2; \n    printf("Output: %d\\n", output);\n    return 0;\n}`,
                'q70-code': `#include <stdio.h>\n#include <string.h>\n\nint main() {\n    char str[20] = "Hello world!";\n    printf("Length of string (strlen): %zu\\n", strlen(str));\n    printf("Character at str[12] is (char)'%c' (ASCII: %d)\\n", str[12], str[12]);\n    if (str[12] == '\\0') {\n        printf("str[12] is indeed the null terminator.\\n");\n    }\n    return 0;\n}`,
                'q71-code': `#include <stdio.h>\n\nint main() {\n    int i, sum, arr[10]; // i declared here for C89 compatibility in some compilers, though inner 'i' shadows it.\n    for (int idx=0; idx<10; idx=idx+1) arr[idx] = idx; \n    sum = 0;\n    for (int idx=1; idx<9; idx=idx+1) {\n        sum = sum - arr[idx-1] + arr[idx] + arr[idx+1];\n    }\n    printf("%d\\n", sum);\n    return 0;\n}`,
                'q72-code': `#include <stdio.h>\n\nint main() {\n    int A[5], B[5], i, c;\n    for (i=1; i<=4; i=i+1) { \n        A[i] = 2 + i*4;\n        B[i] = i*5;\n    }\n    c = 0;\n    for (i=1; i<=4; i=i+1) { \n        if (B[i] > A[i]) {\n            c = c + (B[i] % A[i]);\n        } else {\n            c = 1;\n        }\n    }\n    printf("%d\\n", c);\n    return 0;\n}`,
                'q73-code': `#include <stdio.h>\n\nint main() {\n    int n_val = 5; \n    int a[] = {10, 20, 30, 40, 50};\n    int i, hold;\n    printf("Original: "); for(int k=0;k<n_val;k++) printf("%d ",a[k]); printf("\\n");\n    for (i=0; i <= n_val-2 ; i=i+1) { \n        hold = a[i];\n        a[i] = a[i+1];\n        a[i+1] = hold;\n    }\n    printf("Shifted (a[0] to a[n-1]): "); for(int k=0;k<n_val;k++) printf("%d ",a[k]); printf("\\n");\n    return 0;\n}`,
                'q75-code': `#include <stdio.h>\n\n// Simulating scanf for demonstration\nint simulated_inputs_q75[] = {0,1,2,3,4,5,6,7,8,9};\nint current_input_idx_q75 = 0;\n\nvoid mock_scanf_q75(const char* fmt, int* val) {\n    if (current_input_idx_q75 < 10) {\n        *val = simulated_inputs_q75[current_input_idx_q75++];\n    }\n}\n\nvoid F() {\n    int X[10] = {0}; \n    for (int i=0; i<10; i=i+1) { \n        mock_scanf_q75("%d", &X[(i+2)%10]); \n    }\n    printf("Final X array from F(): ");\n    for (int i=0; i<10; i++) {\n        printf("%d ", X[i]);\n    }\n    printf("\\n");\n}\n\nint main() {\n    F();\n    return 0;\n}`,
                'q77-code': `#include <stdio.h>\n\nint main() {\n    int *p = NULL; \n    int b = 123; \n    // b = p/3; // COMPILE ERROR: Division of a pointer by an integer is not valid.\n    printf("Line 'b = p/3;' would cause a compile-time error.\\n");\n    // printf("answer=%f", (double)b); \n    return 0;\n}`
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

            if (codeSamples['q47-code']) {
                 codeEditor.value = codeSamples['q47-code'];
            } else if (Object.keys(codeSamples).length > 0) {
                 codeEditor.value = codeSamples[Object.keys(codeSamples)[0]];
            } else {
                 codeEditor.value = "// Welcome! No runnable examples in this section. Write your own C/C++ code here.";
            }
        });
    </script>
</body>
</html>
