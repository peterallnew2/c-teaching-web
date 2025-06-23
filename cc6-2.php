<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C 語言 函式與進階應用 (cc6-2)</title>

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
            <h1>C 語言練習：第六章 Part 2 - 函式應用與範圍</h1>
            <p>本頁面為 C/C++ 語言第六章練習題的第二部分 (原第 26-46 題，其中 Q37 略過，共20題)。此部分包含更多函式應用、遞迴、變數範圍、指標參數以及程式碼分析與除錯的題目。請仔細分析每個問題，並利用右側的沙箱進行實作與驗證。</p>

            <div class="quiz-section">
                <h2>第六章 互動練習題組 (2/2)</h2>
                <p>請挑戰下面的題目，檢驗您的學習成果！</p>
                <!-- QUIZ CARDS START -->
                <div id="q1" class="quiz-card">
                    <h3>1. (原 Q26) 執行下列程式碼後，請問輸出結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int TestYou(int a, int b){
    if (b==0) return 1;
    if (b==1) return a;
    else return (a*TestYou(a, b-1));
}
int main(void){ // Corrected main
    int c=TestYou(2,7);
    printf("%d\n", c); // Corrected %i to %d
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q1-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 128</div>
                        <div class="option" data-option="B">(B) 256</div>
                        <div class="option" data-option="C">(C) 512</div>
                        <div class="option" data-option="D">(D) 511</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：遞迴計算次方</h4>
                        <p>函式 <code>TestYou(a, b)</code> 用遞迴方式計算 <code>a</code> 的 <code>b</code> 次方 (a<sup>b</sup>)。</p>
                        <p>追蹤 <code>TestYou(2, 7)</code>：</p>
                        <ul>
                            <li><code>TestYou(2, 7)</code> → 2 * <code>TestYou(2, 6)</code></li>
                            <li><code>TestYou(2, 6)</code> → 2 * <code>TestYou(2, 5)</code></li>
                            <li><code>TestYou(2, 5)</code> → 2 * <code>TestYou(2, 4)</code></li>
                            <li><code>TestYou(2, 4)</code> → 2 * <code>TestYou(2, 3)</code></li>
                            <li><code>TestYou(2, 3)</code> → 2 * <code>TestYou(2, 2)</code></li>
                            <li><code>TestYou(2, 2)</code> → 2 * <code>TestYou(2, 1)</code></li>
                            <li><code>TestYou(2, 1)</code> → 回傳 2 (因為 b==1)</li>
                        </ul>
                        <p>逐層回代：</p>
                        <ul>
                            <li><code>TestYou(2, 2)</code> = 2 * 2 = 4</li>
                            <li><code>TestYou(2, 3)</code> = 2 * 4 = 8</li>
                            <li><code>TestYou(2, 4)</code> = 2 * 8 = 16</li>
                            <li><code>TestYou(2, 5)</code> = 2 * 16 = 32</li>
                            <li><code>TestYou(2, 6)</code> = 2 * 32 = 64</li>
                            <li><code>TestYou(2, 7)</code> = 2 * 64 = 128</li>
                        </ul>
                        <p>所以，<code>c</code> 的值為 128。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q2">下一題</button></div>
                </div>

                <div id="q2" class="quiz-card">
                    <h3>2. (原 Q27) 有一 C 程式片段如下，其中 round( )是四捨五入的函數，執行的結果下列何者正確？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
#include &lt;string.h&gt; // Not strictly needed for this snippet
#include &lt;math.h&gt;   // For round()
int main(void){ // Corrected main
    float dataB[4]={2.2, 2.8, -2.4, -1.8};
    int j, result=0;
    for(j=0;j&lt;4;j++){
        result = result + round(dataB[j]);
    }
    printf("%d\n", result); // Added newline for clarity
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q2-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) -1</div>
                        <div class="option" data-option="B">(B) 0</div>
                        <div class="option" data-option="C">(C) 1</div>
                        <div class="option" data-option="D">(D) 2</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：<code>round()</code> 函式與迴圈加總</h4>
                        <p>函式 <code>round(x)</code> 會將浮點數 <code>x</code> 四捨五入到最接近的整數。如果小數部分剛好是 .5，則通常會進位到離零更遠的整數 (例如 round(2.5)是3, round(-2.5)是-3)。</p>
                        <p>陣列 <code>dataB = {2.2, 2.8, -2.4, -1.8}</code>。</p>
                        <p>追蹤迴圈與 <code>result</code> 的變化：</p>
                        <table>
                            <thead><tr><th>j</th><th>dataB[j]</th><th>round(dataB[j])</th><th>result (累計)</th></tr></thead>
                            <tbody>
                                <tr><td>-</td><td>-</td><td>-</td><td>0 (初始)</td></tr>
                                <tr><td>0</td><td>2.2</td><td>round(2.2) = 2</td><td>0 + 2 = 2</td></tr>
                                <tr><td>1</td><td>2.8</td><td>round(2.8) = 3</td><td>2 + 3 = 5</td></tr>
                                <tr><td>2</td><td>-2.4</td><td>round(-2.4) = -2</td><td>5 + (-2) = 3</td></tr>
                                <tr><td>3</td><td>-1.8</td><td>round(-1.8) = -2</td><td>3 + (-2) = 1</td></tr>
                            </tbody>
                        </table>
                        <p>最終 <code>result</code> 的值為 1。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q3">下一題</button></div>
                </div>

                <div id="q3" class="quiz-card">
                    <h3>3. (原 Q28) 在下列程式片段中，呼叫 printDigit(n)，輸入 n 為 1234，請問輸出為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt; // For printf
void printDigit(int n){
    printf("%d", n%10);
    if (n/10 != 0){ // Condition to recurse if there are more digits
        printDigit(n/10);
    }
}</code></pre>
                    <button class="run-example-btn" data-code-id="q3-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) . 10</div>
                        <div class="option" data-option="B">(B) . 4321</div>
                        <div class="option" data-option="C">(C) . 1234</div>
                        <div class="option" data-option="D">(D) . 0</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：遞迴列印數字</h4>
                        <p>函式 <code>printDigit(n)</code> 使用遞迴來列印數字的每一位。它首先印出 <code>n%10</code> (個位數)，然後如果 <code>n/10</code> 不是 0 (表示還有更高位數)，則遞迴呼叫 <code>printDigit(n/10)</code>。</p>
                        <p>追蹤 <code>printDigit(1234)</code>：</p>
                        <ol>
                            <li><strong><code>printDigit(1234)</code></strong>:
                                <ul>
                                    <li><code>printf("%d", 1234%10)</code> → 印出 "4"</li>
                                    <li><code>1234/10 != 0</code> (123 != 0) is true.</li>
                                    <li>呼叫 <code>printDigit(123)</code>.</li>
                                </ul>
                            </li>
                            <li><strong><code>printDigit(123)</code></strong>:
                                <ul>
                                    <li><code>printf("%d", 123%10)</code> → 印出 "3" (目前總輸出: "43")</li>
                                    <li><code>123/10 != 0</code> (12 != 0) is true.</li>
                                    <li>呼叫 <code>printDigit(12)</code>.</li>
                                </ul>
                            </li>
                            <li><strong><code>printDigit(12)</code></strong>:
                                <ul>
                                    <li><code>printf("%d", 12%10)</code> → 印出 "2" (目前總輸出: "432")</li>
                                    <li><code>12/10 != 0</code> (1 != 0) is true.</li>
                                    <li>呼叫 <code>printDigit(1)</code>.</li>
                                </ul>
                            </li>
                            <li><strong><code>printDigit(1)</code></strong>:
                                <ul>
                                    <li><code>printf("%d", 1%10)</code> → 印出 "1" (目前總輸出: "4321")</li>
                                    <li><code>1/10 != 0</code> (0 != 0) is false. 遞迴停止。</li>
                                </ul>
                            </li>
                        </ol>
                        <p>因為 <code>printf</code> 是在遞迴呼叫之前執行，所以數字的位數是反向印出的。</p>
                        <p>最終輸出為 "4321"。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q4">下一題</button></div>
                </div>

                <div id="q4" class="quiz-card">
                    <h3>4. (原 Q29) 在下列程式片段中，執行結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
void swap(int a, int b){ // Pass by value
    int temp;
    temp = a;
    a = b;
    b = temp;
    // Changes to a and b here are local to swap function
}

int main(void){ // Corrected main
    int a=10, b=20;
    // printf("Before swap: a = %d, b = %d\n", a, b);
    swap(a, b); // Copies of a and b are passed
    printf("a = %d, b = %d\n", a, b);
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q4-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) . a = 10， b = 20</div>
                        <div class="option" data-option="B">(B) . a = 10， b = 10</div>
                        <div class="option" data-option="C">(C) . a = 20， b = 20</div>
                        <div class="option" data-option="D">(D) . a = 20， b = 10</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：傳值呼叫 (Call by Value)</h4>
                        <p>在 C 語言中，預設的函式參數傳遞方式是「傳值呼叫」。這意味著當你呼叫一個函式並傳遞變數給它時，實際上传遞的是那些變數的值的「副本」。函式內部的參數變數是這些副本，對它們的任何修改都只在函式內部有效，不會影響到呼叫者函式中的原始變數。</p>
                        <p>分析程式碼：</p>
                        <ol>
                            <li>在 <code>main</code> 函式中：
                                <ul>
                                    <li><code>int a=10, b=20;</code>：變數 <code>a</code> 初始化為 10，<code>b</code> 初始化為 20。</li>
                                </ul>
                            </li>
                            <li>呼叫 <code>swap(a, b);</code>：
                                <ul>
                                    <li><code>a</code> 的值 (10) 被複製到 <code>swap</code> 函式的參數 <code>a</code>。</li>
                                    <li><code>b</code> 的值 (20) 被複製到 <code>swap</code> 函式的參數 <code>b</code>。</li>
                                </ul>
                            </li>
                            <li>在 <code>swap</code> 函式內部：
                                <ul>
                                    <li><code>int temp;</code></li>
                                    <li><code>temp = a;</code> (<code>temp</code> 變成 10，這裡的 <code>a</code> 是 <code>swap</code> 內的副本)</li>
                                    <li><code>a = b;</code> (<code>swap</code> 內的 <code>a</code> 變成 20)</li>
                                    <li><code>b = temp;</code> (<code>swap</code> 內的 <code>b</code> 變成 10)</li>
                                    <li>此時，在 <code>swap</code> 函式的作用域內，<code>a</code> 是 20，<code>b</code> 是 10。但這些都是區域副本的改變。</li>
                                </ul>
                            </li>
                            <li>當 <code>swap</code> 函式執行完畢並返回到 <code>main</code> 函式：
                                <ul>
                                    <li><code>main</code> 函式中的變數 <code>a</code> 和 <code>b</code> 的值從未被 <code>swap</code> 函式直接修改，因為 <code>swap</code> 操作的是它們的副本。</li>
                                    <li>所以，<code>main</code> 中的 <code>a</code> 仍然是 10，<code>b</code> 仍然是 20。</li>
                                </ul>
                            </li>
                            <li><code>printf("a = %d, b = %d\n", a, b);</code>：印出 <code>main</code> 函式中 <code>a</code> 和 <code>b</code> 的值。</li>
                        </ol>
                        <p>因此，輸出結果是 "a = 10, b = 20"。</p>
                        <p>若要讓 <code>swap</code> 函式能夠修改 <code>main</code> 中的變數，需要使用指標 (傳址呼叫)。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q5">下一題</button></div>
                </div>

                <!-- ... remaining 16 cards ... -->

                <div id="q20" class="quiz-card">
                    <h3>20. (原 Q46) 曉華想要把交換整數資料的程式碼寫成副程式，因此把行號 17, 18, 19 的程式改為註解，並且將行號 16 的註解拿掉以便啓用函式呼叫 swap(.)，結果發現程式無法執行並出現錯誤訊息 expected ‘ int ’ but argument is of type ‘ int * ’，錯誤原因為何？</h3>
                    <pre><code class="language-c">// Code from Q45 context:
//1 #include &lt;stdio.h&gt;
//2 #define N 11
//3 void swap(int a, int b){ // Pass-by-value swap
//4 int tmp;
//5 tmp=a;
//6 a=b;
//7 b=tmp;
//8 }
//9 void main(void){ // Should be int main(void)
//10 int numbers[N]={1,3,5,7,9,2,4,6,8,0,'a'};
//11 int tmp, i, min;
//12 //min=0;
//13 for(min=0; min&lt;N; min++)
//14   for(i=0; i&lt;N; i++){
//15     if(numbers[i]&lt;numbers[min]){
//16       //swap(numbers+i, numbers+min); // If this line is used
//17       //tmp=numbers[min];
//18       //numbers[min]=numbers[i];
//19       //numbers[i]=tmp;
//20     }
//21   }
//22   // ... printf loop ...
//25 }
</code></pre>
                    <!-- No run button as this is error analysis -->
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 行號 16 呼叫 swap()時，使用的引數資料型態與副程式不一致</div>
                        <div class="option" data-option="B">(B) 行號 16 的 numbers 是陣列指標，不能和整數 i, min 相加</div>
                        <div class="option" data-option="C">(C) 行號 10 的陣列宣告中，字元'a'和 swap(.)函式中的整數變數 a 名稱上有衝突</div>
                        <div class="option" data-option="D">(D) 行號 12 註解，導致 min 沒有初始值。</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：函式呼叫與型別匹配</h4>
                        <p>首先，我們看 <code>swap</code> 函式的定義 (行號 3-8)：</p>
                        <p><code>void swap(int a, int b)</code></p>
                        <p>這個函式期望接收兩個 <code>int</code> 型態的參數。這是一個「傳值呼叫」的 swap，它在函式內部交換的是傳入值的副本，並不會影響到呼叫端的原始變數。</p>
                        <p>現在看行號 16，如果取消註解：</p>
                        <p><code>swap(numbers+i, numbers+min);</code></p>
                        <ul>
                            <li><code>numbers</code> 是一個 <code>int</code> 陣列。</li>
                            <li><code>numbers+i</code>：這是指標運算。<code>numbers</code> 本身可以被視為指向陣列第一個元素 (<code>&amp;numbers[0]</code>) 的指標。所以 <code>numbers+i</code> 是一個指向 <code>numbers[i]</code> 的 <code>int*</code> (整數指標) 型態的位址。</li>
                            <li><code>numbers+min</code>：同理，這也是一個 <code>int*</code> 型態的位址，指向 <code>numbers[min]</code>。</li>
                        </ul>
                        <p>所以，行號 16 的呼叫實際上是 <code>swap(int*, int*)</code>。</p>
                        <p>錯誤訊息是 "expected ‘int’ but argument is of type ‘int *’"。這意味著：</p>
                        <ul>
                            <li>函式 <code>swap</code> 被定義為期望接收 <code>int</code> 型態的參數 (如 <code>void swap(int a, int b)</code>)。</li>
                            <li>但是在呼叫時 (行號 16)，傳遞給它的是 <code>int*</code> (整數指標) 型態的參數 (<code>numbers+i</code> 和 <code>numbers+min</code>)。</li>
                        </ul>
                        <p>這正是型別不匹配。函式期望一個整數值，但卻收到了記憶體位址。</p>
                        <p>分析選項：</p>
                        <ul>
                            <li><strong>(A) 行號 16 呼叫 swap()時，使用的引數資料型態與副程式不一致：</strong> 這是正確的。傳遞了 <code>int*</code> 給期望 <code>int</code> 的參數。</li>
                            <li><strong>(B) 行號 16 的 numbers 是陣列指標，不能和整數 i, min 相加：</strong> <code>numbers</code> (作為陣列名用在表達式中) 會衰退 (decay) 為指向其首元素的指標。指標可以和整數相加（指標運算），所以 <code>numbers+i</code> 是合法的。這不是錯誤原因。</li>
                            <li><strong>(C) 行號 10 的陣列宣告中，字元'a'和 swap(.)函式中的整數變數 a 名稱上有衝突：</strong> 變數名稱的作用域不同。<code>main</code> 函式中的陣列 <code>numbers</code> 包含 <code>'a'</code> (其 ASCII 值) 與 <code>swap</code> 函式的參數 <code>a</code> 沒有名稱衝突。型別衝突是另一回事 (<code>'a'</code> 在 <code>numbers</code> 中被當作整數 ASCII 值處理)。</li>
                            <li><strong>(D) 行號 12 註解，導致 min 沒有初始值：</strong> <code>min</code> 在行號 13 的 <code>for</code> 迴圈中被初始化 (<code>min=0</code>)。所以這不是原因。</li>
                        </ul>
                        <p>要使交換生效且符合 <code>void swap(int *a, int *b)</code> 這樣的傳址呼叫原型，呼叫應為 <code>swap(&amp;numbers[i], &amp;numbers[min]);</code>。但題目中的 <code>swap</code> 是傳值版本，本身就無法交換 <code>main</code> 中的元素。不過，錯誤訊息是針對型別不匹配的。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q1">回到本頁第一題</button></div>
                </div>
                <!-- QUIZ CARDS END -->
            </div>
        </main>

        <div class="resizer" id="dragMe"></div>

        <aside class="interactive-panel">
            <div class="interactive-panel-inner">
                <div class="sandbox-container">
                    <h3>C 語言程式碼沙箱 (WASM)</h3>
                    <textarea id="code-editor" spellcheck="false">/* Default code will be loaded by JavaScript */</textarea>
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
            const codeSamples = {
                'q1-code': '#include <stdio.h>\nint TestYou(int a, int b){ if (b==0) return 1; if (b==1) return a; else return (a*TestYou(a, b-1)); }\nint main(void){ int c=TestYou(2,7); printf("%d\\n", c); return 0; }',
                'q2-code': '#include <stdio.h>\n#include <math.h>\nint main(void){\n    float dataB[4]={2.2, 2.8, -2.4, -1.8};\n    int j, result=0;\n    for(j=0;j<4;j++){ result = result + round(dataB[j]); }\n    printf("%d\\n", result);\n    return 0;\n}',
                'q3-code': '#include <stdio.h>\nvoid printDigit(int n){\n    printf("%d", n%10);\n    if (n/10 != 0){\n        printDigit(n/10);\n    }\n}\nint main(void){ printDigit(1234); printf("\\n"); return 0; }',
                'q4-code': '#include <stdio.h>\nvoid swap(int a, int b){ int temp; temp = a; a = b; b = temp; }\nint main(void){\n    int a=10, b=20;\n    printf("Before swap: a = %d, b = %d\\n", a, b);\n    swap(a, b);\n    printf("After swap: a = %d, b = %d\\n", a, b);\n    return 0;\n}',
                'q5-code': '#include <stdio.h>\nint f(int n){ if (n==1) return 1; else return f(n-1) + n - 1; }\nint main(void){ printf("f(4) = %d\\n", f(4)); return 0; }',
                'q6-code': '#include <stdio.h>\nint fibonacci(int n){ if (n==0 || n==1) return n; else return fibonacci(n-1)+fibonacci(n-2); }\nint main(void){ printf("fibonacci(6) = %d\\n", fibonacci(6)); return 0; }',
                'q7-code': '#include <stdio.h>\nint FunctionA(int x, int y){ if (y==0) return 1; if (y==1) return x; else return (x * FunctionA(x,y-1)); }\nint main(void){ int c=FunctionA(3,6); printf("%d\\n", c); return 0; }',
                'q8-code': '#include <stdio.h>\nint f_find_max_idx(int a[], int n){\n    int index = 0;\n    for (int i=1; i<=n-1; i=i+1){ if (a[i] >= a[index]){ index = i; } }\n    return index;\n}\nint main(void) {\n    int a[9]={1,2,3,4,7,5,9,6,8};\n    int ret=0; ret=f_find_max_idx(a, 9);\n    printf("%d\\n", ret);\n    return 0;\n}',
                'q9-code': '#include <stdio.h>\nint s_global_q34=1;\nvoid add_q34(int a){ s_global_q34 = s_global_q34+a; printf("%d ", s_global_q34); }\nint main(void) {\n    int s_local_q34=10;\n    printf("%d ", s_local_q34);\n    add_q34(s_local_q34);\n    printf("%d\\n", s_local_q34);\n    return 0;\n}',
                'q10-code': '#include <stdio.h>\nint s_global_q35=1;\nvoid add_q35(int a){ int s_local_add=1; s_local_add = s_local_add+a; printf("%d ", s_local_add); }\nint main(void) {\n    int s_main_q35=10;\n    add_q35(s_main_q35);\n    add_q35(s_main_q35);\n    printf("\\nGlobal s_global_q35 is: %d\\n", s_global_q35);\n    return 0;\n}',
                'q11-code': '#include <stdio.h>\nvoid funC(int* o, int q){ int p=5; q=3+p; *o=p*q; }\nint main(void) {\n    int f_val=2, s_val=3;\n    printf("Before: f_val=%d, s_val=%d\\n", f_val, s_val);\n    funC(&s_val, f_val);\n    printf("After: ");\n    printf("%4d%4d\\n", f_val, s_val);\n    return 0;\n}',
                'q13-code': '#include <stdio.h>\n void sub_q39(int i, char *s){\n    printf("total %d arguments, and the 2nd one is %s\\n", i, s);\n}\nint main(int argc, char *argv[]) {\n    printf("Program name: %s\\n", argv[0]);\n    if (argc > 2) { \n        printf("Calling sub_q39 with argv[2]\\n");\n        sub_q39(argc, argv[2]);\n    } else if (argc > 1) {\n        printf("Calling sub_q39 with argv[1] as placeholder for argv[2]\\n");\n        sub_q39(argc, argv[1]);\n    } else {\n        printf("Not enough arguments. Need at least program name and one more for argv[1] (or two for argv[2]).\\n");\n    }\n    return 0;\n}',
                'q14-code': '#include <stdio.h>\nint sum_global_q40=1, x_global_q40=10;\nint inc_q40(int xin_param ){\n    int sum_local_inc=2;\n    sum_local_inc = sum_local_inc + xin_param;\n    xin_param++; \n    printf("In inc_q40: xin_param (after ++)=%d, sum_local_inc=%d, sum_global_q40=%d\\n", xin_param, sum_local_inc, sum_global_q40);\n    return (sum_local_inc);\n}\nint main(void){\n    int sum_local_main = 3;\n    printf("In main (before inc): sum_local_main=%d, x_global_q40=%d, sum_global_q40=%d\\n", sum_local_main, x_global_q40, sum_global_q40);\n    sum_local_main=inc_q40(x_global_q40);\n    printf("In main (after inc): sum_local_main=%d, x_global_q40=%d\\n", sum_local_main, x_global_q40);\n    return 0;\n}',
                'q16-code': '#include <stdio.h>\nfloat a_q43=1, b_q43=0, c_q43=-1; /* Global for original error, or pass as params */ \nfloat f_q43(float x){\n    /* return(a_q43*x*x+b_q43*x+c_q43); // Using globals */ \n    // Corrected version would take a,b,c as params or use globals if defined as such for demo \n    printf("Note: For this demo, f_q43 uses global a_q43,b_q43,c_q43 or passed params if modified.\\n"); \n    return(a_q43*x*x + b_q43*x + c_q43); \n}\nint main(void){\n    float x_val;\n    printf("Using global a=%.1f, b=%.1f, c=%.1f\\n", a_q43,b_q43,c_q43);\n    for(x_val=-2; x_val<=2; x_val=x_val+1.0) {\n        printf("f(%.1f)=%.1f\\n", x_val, f_q43(x_val));\n    }\n    return 0;\n}',
                'q18-code': '#include <stdio.h>\n#define N_Q45 11\nint main(void){\n    int numbers[N_Q45]={1,3,5,7,9,2,4,6,8,0,\'a\'};\n    int tmp, i, min_idx;\n    printf("Original: "); for(i=0; i<N_Q45; i++) printf("%d ", numbers[i]); printf("\\n");\n    for(min_idx=0; min_idx<N_Q45; min_idx++) {\n        for(i=0; i<N_Q45; i++){\n            if(numbers[i]<numbers[min_idx]){\n                tmp=numbers[min_idx];\n                numbers[min_idx]=numbers[i];\n                numbers[i]=tmp;\n            }\n        }\n    }\n    printf("Sorted:   ");\n    for(i=0; i<N_Q45; i++){ printf("%d ", numbers[i]); }\n    printf("\\n");\n    return 0;\n}'
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

            // Load first available code sample into editor, or a default message
            if (codeSamples['q1-code']) {
                 codeEditor.value = codeSamples['q1-code'];
            } else if (Object.keys(codeSamples).length > 0) {
                 codeEditor.value = codeSamples[Object.keys(codeSamples)[0]];
            } else {
                 codeEditor.value = "// Welcome! No runnable examples in this section. Write your own C/C++ code here.";
            }
        });
    </script>
</body>
</html>
