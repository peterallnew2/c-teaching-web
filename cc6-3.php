<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C 語言 函式與進階應用 (cc6-3)</title>

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
            <h1>C 語言練習：第六章 Part 3 - 函式、範圍與應用</h1>
            <p>本頁面為 C/C++ 語言第六章練習題的第三部分 (原第 26-44 題，其中 Q37 略過，共19題)。此部分持續探討函式應用、遞迴、變數範圍、指標參數以及程式碼分析與除錯。請仔細分析每個問題，並利用右側的沙箱進行實作與驗證。</p>

            <div class="quiz-section">
                <h2>第六章 互動練習題組 (3/?)</h2> <!-- Placeholder for total parts -->
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
int main(void){ // Corrected
    int c=TestYou(2,7);
    printf("%d\n", c); // Corrected %i to %d and added newline
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
#include &lt;math.h&gt;   // For round()
int main(void){ // Corrected main
    float dataB[4]={2.2, 2.8, -2.4, -1.8};
    int j, result=0;
    for(j=0;j&lt;4;j++){
        result = result + round(dataB[j]);
    }
    printf("%d\n", result);
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
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
void printDigit(int n){
    printf("%d", n%10);
    if (n/10 != 0){ // More robust condition
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
                            <li><strong><code>printDigit(1234)</code></strong>: 印出 "4", 呼叫 <code>printDigit(123)</code>.</li>
                            <li><strong><code>printDigit(123)</code></strong>: 印出 "3", 呼叫 <code>printDigit(12)</code>. (輸出: "43")</li>
                            <li><strong><code>printDigit(12)</code></strong>: 印出 "2", 呼叫 <code>printDigit(1)</code>. (輸出: "432")</li>
                            <li><strong><code>printDigit(1)</code></strong>: 印出 "1". <code>1/10 == 0</code>, 遞迴停止. (輸出: "4321")</li>
                        </ol>
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
}
int main(void){
    int a=10, b=20;
    swap(a, b);
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
                        <p>C 語言預設使用「傳值呼叫」。當 <code>swap(a, b)</code> 被呼叫時，<code>main</code> 函式中 <code>a</code> 和 <code>b</code> 的值被複製到 <code>swap</code> 函式的參數 <code>a</code> 和 <code>b</code>。<code>swap</code> 函式內部對這些副本進行交換，但這不會影響 <code>main</code> 函式中的原始變數 <code>a</code> 和 <code>b</code>。</p>
                        <p>因此，<code>printf</code> 語句將印出 <code>main</code> 中未改變的 <code>a</code> 和 <code>b</code> 的值。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q5">下一題</button></div>
                </div>

                <div id="q5" class="quiz-card">
                    <h3>5. (原 Q30) 下列程式片段中，f(4)的輸出應該為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt; // For main example
int f(int n){
    if (n==1)
        return 1;
    else
        return f(n-1) + n - 1;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q5-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) . 2</div>
                        <div class="option" data-option="B">(B) . 4</div>
                        <div class="option" data-option="C">(C) . 7</div>
                        <div class="option" data-option="D">(D) . 11</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：遞迴函式追蹤</h4>
                        <p>追蹤 <code>f(4)</code>：</p>
                        <ul>
                            <li><code>f(4)</code> → <code>f(3) + 4 - 1</code> = <code>f(3) + 3</code></li>
                            <li><code>f(3)</code> → <code>f(2) + 3 - 1</code> = <code>f(2) + 2</code></li>
                            <li><code>f(2)</code> → <code>f(1) + 2 - 1</code> = <code>f(1) + 1</code></li>
                            <li><code>f(1)</code> → 回傳 1 (基本情況)</li>
                        </ul>
                        <p>回代：</p>
                        <ul>
                            <li><code>f(2)</code> = 1 + 1 = 2</li>
                            <li><code>f(3)</code> = 2 + 2 = 4</li>
                            <li><code>f(4)</code> = 4 + 3 = 7</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q6">下一題</button></div>
                </div>

                <div id="q6" class="quiz-card">
                    <h3>6. (原 Q31) 呼叫下列的函式，fibonacci(6)答案為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt; // For main example
int fibonacci(int n){
    if (n==0 || n==1) return n;
    else return fibonacci(n-1)+fibonacci(n-2);
}</code></pre>
                    <button class="run-example-btn" data-code-id="q6-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) . 3</div>
                        <div class="option" data-option="B">(B) . 5</div>
                        <div class="option" data-option="C">(C) . 8</div>
                        <div class="option" data-option="D">(D) . 13</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：費氏數列遞迴</h4>
                        <p>計算費氏數列：F(0)=0, F(1)=1, F(n)=F(n-1)+F(n-2)</p>
                        <ul>
                            <li><code>fibonacci(0) = 0</code></li>
                            <li><code>fibonacci(1) = 1</code></li>
                            <li><code>fibonacci(2) = 1+0 = 1</code></li>
                            <li><code>fibonacci(3) = 1+1 = 2</code></li>
                            <li><code>fibonacci(4) = 2+1 = 3</code></li>
                            <li><code>fibonacci(5) = 3+2 = 5</code></li>
                            <li><code>fibonacci(6) = 5+3 = 8</code></li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q7">下一題</button></div>
                </div>

                <div id="q7" class="quiz-card">
                    <h3>7. (原 Q32) 請問下列程式片段執行後，會印出甚麼？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int FunctionA(int x, int y){
    if (y==0) return 1;
    if (y==1) return x;
    else return (x * FunctionA(x,y-1));
}
int main(void){ // Corrected
    int c=FunctionA(3,6);
    printf("%d\n", c); // Corrected %i to %d
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q7-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) . 729</div>
                        <div class="option" data-option="B">(B) . 3</div>
                        <div class="option" data-option="C">(C) . 243</div>
                        <div class="option" data-option="D">(D) . 128</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：遞迴計算次方</h4>
                        <p>函式 <code>FunctionA(x, y)</code> 計算 x<sup>y</sup>。</p>
                        <p>追蹤 <code>FunctionA(3, 6)</code>：</p>
                        <ul>
                            <li><code>FunctionA(3,6)</code> → 3 * <code>FunctionA(3,5)</code></li>
                            <li><code>FunctionA(3,5)</code> → 3 * <code>FunctionA(3,4)</code></li>
                            <li><code>FunctionA(3,4)</code> → 3 * <code>FunctionA(3,3)</code></li>
                            <li><code>FunctionA(3,3)</code> → 3 * <code>FunctionA(3,2)</code></li>
                            <li><code>FunctionA(3,2)</code> → 3 * <code>FunctionA(3,1)</code></li>
                            <li><code>FunctionA(3,1)</code> → 回傳 3</li>
                        </ul>
                        <p>回代：3 * 3 * 3 * 3 * 3 * 3 = 3<sup>6</sup> = 729。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q8">下一題</button></div>
                </div>

                <div id="q8" class="quiz-card">
                    <h3>8. (原 Q33) 有一程式如下所示，執行後，顯示值為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int f_q33(int a[], int n){ // Renamed
    int index = 0;
    for (int i=1; i&lt;=n-1; i=i+1){ // Corrected loop condition to i < n or i <= n-1
        if (a[i] &gt;= a[index]){ // Finds last occurrence of max
            index = i;
        }
    }
    return index;
}
int main(void) {
    int a[9]={1,2,3,4,7,5,9,6,8}; // n=9, indices 0-8
    int ret=0;
    ret=f_q33(a, 9);
    printf("%d\n", ret);
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q8-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 0</div>
                        <div class="option" data-option="B">(B) 1</div>
                        <div class="option" data-option="C">(C) 6</div>
                        <div class="option" data-option="D">(D) 9</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：尋找最大元素索引</h4>
                        <p>函式 <code>f_q33(a, n)</code> (原名 f) 遍歷陣列 <code>a</code> (大小為 <code>n</code>)，尋找並回傳最大元素的索引。如果有多個相同的最大元素，它會回傳最後一個出現的最大元素的索引，因為條件是 <code>a[i] >= a[index]</code>。</p>
                        <p>陣列 <code>a = {1,2,3,4,7,5,9,6,8}</code>，<code>n=9</code>。</p>
                        <p>追蹤：</p>
                        <ul>
                            <li>初始: <code>index = 0</code> (<code>a[0]=1</code>)</li>
                            <li>i=1: <code>a[1]=2</code>. 2 >= 1. <code>index = 1</code>.</li>
                            <li>i=2: <code>a[2]=3</code>. 3 >= 2. <code>index = 2</code>.</li>
                            <li>i=3: <code>a[3]=4</code>. 4 >= 3. <code>index = 3</code>.</li>
                            <li>i=4: <code>a[4]=7</code>. 7 >= 4. <code>index = 4</code>.</li>
                            <li>i=5: <code>a[5]=5</code>. 5 >= 7 is false.</li>
                            <li>i=6: <code>a[6]=9</code>. 9 >= 7. <code>index = 6</code>.</li>
                            <li>i=7: <code>a[7]=6</code>. 6 >= 9 is false.</li>
                            <li>i=8: <code>a[8]=8</code>. 8 >= 9 is false.</li>
                        </ul>
                        <p>迴圈結束，<code>index</code> 為 6。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q9">下一題</button></div>
                </div>

                <div id="q9" class="quiz-card">
                    <h3>9. (原 Q34) 下列程式執行結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int s_q34=1; // Global variable, renamed for clarity
void add_q34(int); // Prototype
int main(void) { // Corrected main
    int s=10; // Local variable in main, shadows global s_q34
    printf("%d ", s);
    add_q34(s);
    printf("%d\n", s); // Prints local s from main
    return 0;
}
void add_q34(int a){
    s_q34 = s_q34+a; // Modifies global s_q34
    printf("%d ", s_q34);
}</code></pre>
                    <button class="run-example-btn" data-code-id="q9-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 10 20 10</div>
                        <div class="option" data-option="B">(B) 10 10 10</div>
                        <div class="option" data-option="C">(C) 10 10 20</div>
                        <div class="option" data-option="D">(D) 10 11 10</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：變數範圍 (全域與區域)</h4>
                        <p>程式中有一個全域變數 <code>s_q34</code> (原名 s) 初始化為 1。</p>
                        <p><code>main</code> 函式中有一個同名的區域變數 <code>s</code> 初始化為 10。在 <code>main</code> 內部，這個區域 <code>s</code> 會遮蔽 (shadow) 全域 <code>s_q34</code>。</p>
                        <p><code>add_q34</code> 函式沒有宣告區域變數 <code>s</code>，所以它存取的是全域變數 <code>s_q34</code>。</p>
                        <p>執行流程：</p>
                        <ol>
                            <li><code>main</code> 開始：區域 <code>s = 10</code>。全域 <code>s_q34 = 1</code>。</li>
                            <li><code>printf("%d ", s);</code>：印出 <code>main</code> 的區域 <code>s</code>，即 "10 ".</li>
                            <li>呼叫 <code>add_q34(s);</code>：將 <code>main</code> 的區域 <code>s</code> (值為 10) 傳遞給 <code>add_q34</code> 的參數 <code>a</code>。
                                <ul>
                                    <li>在 <code>add_q34</code> 內部: <code>a = 10</code>.</li>
                                    <li><code>s_q34 = s_q34 + a;</code> → <code>s_q34 = 1 + 10 = 11</code>. (全域 <code>s_q34</code> 被修改)</li>
                                    <li><code>printf("%d ", s_q34);</code> → 印出修改後的全局 <code>s_q34</code>，即 "11 ".</li>
                                </ul>
                            </li>
                            <li>回到 <code>main</code>。</li>
                            <li><code>printf("%d\n", s);</code>：再次印出 <code>main</code> 的區域 <code>s</code>。這個變數從未被 <code>add_q34</code> 修改，其值仍為 10。印出 "10".</li>
                        </ol>
                        <p>總輸出: "10 11 10"</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q10">下一題</button></div>
                </div>

                <div id="q10" class="quiz-card">
                    <h3>10. (原 Q35) 下列程式執行結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int s_global_q35=1; // Global variable
void add_q35(int); // Prototype
int main(void) { // Corrected main
    int s_main=10; // Local variable in main
    add_q35(s_main);
    add_q35(s_main);
    printf("\n"); // Added for cleaner output in example
    return 0;
}
void add_q35(int a){
    int s_local_in_add=1; // Local variable in add_q35, shadows global s_global_q35
    s_local_in_add = s_local_in_add+a;
    printf("%d ", s_local_in_add);
}</code></pre>
                    <button class="run-example-btn" data-code-id="q10-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 10 20</div>
                        <div class="option" data-option="B">(B) 11 21</div>
                        <div class="option" data-option="C">(C) 11 11</div>
                        <div class="option" data-option="D">(D) 21 21</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：變數範圍 (區域變數遮蔽全域變數)</h4>
                        <p>程式中有一個全域變數 <code>s_global_q35</code> (原名 s) 初始化為 1。</p>
                        <p><code>main</code> 函式中有一個區域變數 <code>s_main</code> (原名 s) 初始化為 10。</p>
                        <p><code>add_q35</code> 函式也有一個自己的區域變數 <code>s_local_in_add</code> (原名 s) 初始化為 1。這個區域變數 <code>s_local_in_add</code> 在 <code>add_q35</code> 函式內部會遮蔽 (shadow) 全域變數 <code>s_global_q35</code>。</p>
                        <p>執行流程：</p>
                        <ol>
                            <li><code>main</code> 開始：<code>s_main = 10</code>。全域 <code>s_global_q35 = 1</code>。</li>
                            <li>第一次呼叫 <code>add_q35(s_main);</code>：
                                <ul>
                                    <li>參數 <code>a</code> 得到 <code>s_main</code> 的值，即 10。</li>
                                    <li>在 <code>add_q35</code> 內部: 區域變數 <code>s_local_in_add</code> 被宣告並初始化為 1。</li>
                                    <li><code>s_local_in_add = s_local_in_add + a;</code> → <code>s_local_in_add = 1 + 10 = 11</code>.</li>
                                    <li><code>printf("%d ", s_local_in_add);</code> → 印出 "11 ".</li>
                                    <li>此 <code>s_local_in_add</code> 是 <code>add_q35</code> 的區域變數，全域 <code>s_global_q35</code> 未被修改。</li>
                                </ul>
                            </li>
                            <li>第二次呼叫 <code>add_q35(s_main);</code>：
                                <ul>
                                    <li>參數 <code>a</code> 再次得到 <code>s_main</code> 的值，即 10。</li>
                                    <li>在 <code>add_q35</code> 內部: 新的區域變數 <code>s_local_in_add</code> 再次被宣告並初始化為 1 (上一次呼叫的 <code>s_local_in_add</code> 已銷毀)。</li>
                                    <li><code>s_local_in_add = s_local_in_add + a;</code> → <code>s_local_in_add = 1 + 10 = 11</code>.</li>
                                    <li><code>printf("%d ", s_local_in_add);</code> → 印出 "11 ".</li>
                                </ul>
                            </li>
                        </ol>
                        <p>總輸出: "11 11 "</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q11">下一題</button></div>
                </div>

                <div id="q11" class="quiz-card">
                    <h3>11. (原 Q36) 請問下列程式執行後，輸出的數值是？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
void funC(int* o, int q){
    int p=5;
    q=3+p; // q is a local copy of main's f, so main's f is not changed
    *o=p*q; // *o refers to main's s, so main's s is changed
}
int main(void) { // Corrected main
    int f_val=2, s_val=3; // Renamed for clarity
    funC(&amp;s_val, f_val);
    printf("%4d%4d\n", f_val, s_val); // Added newline
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q11-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 2 3</div>
                        <div class="option" data-option="B">(B) 40 3</div>
                        <div class="option" data-option="C">(C) 2 40</div>
                        <div class="option" data-option="D">(D) 40 2</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：傳值與傳址混合</h4>
                        <p><strong>1. 初始狀態 (在 <code>main</code> 中)：</strong></p>
                        <ul>
                            <li><code>f_val = 2</code></li>
                            <li><code>s_val = 3</code></li>
                        </ul>
                        <p><strong>2. 呼叫 <code>funC(&amp;s_val, f_val)</code>：</strong></p>
                        <ul>
                            <li>第一個參數 <code>&amp;s_val</code> 是 <code>s_val</code> 的記憶體位址。所以 <code>funC</code> 中的指標 <code>o</code> 指向 <code>main</code> 的 <code>s_val</code>。 (傳址)</li>
                            <li>第二個參數 <code>f_val</code> 是 <code>f_val</code> 的值。所以 <code>funC</code> 中的 <code>q</code> 得到 <code>f_val</code> 的副本，即 <code>q = 2</code>。 (傳值)</li>
                        </ul>
                        <p><strong>3. 執行 <code>funC</code> 內部：</strong></p>
                        <ul>
                            <li><code>int p=5;</code>：宣告區域變數 <code>p</code> 並設為 5。</li>
                            <li><code>q=3+p;</code> → <code>q = 3 + 5 = 8</code>. (這是 <code>funC</code> 的區域變數 <code>q</code>，<code>main</code> 的 <code>f_val</code> 不受影響)</li>
                            <li><code>*o=p*q;</code> → <code>*o = 5 * 8 = 40</code>. 因為 <code>o</code> 指向 <code>main</code> 的 <code>s_val</code>，所以 <code>main</code> 中的 <code>s_val</code> 被修改為 40。</li>
                        </ul>
                        <p><strong>4. 回到 <code>main</code> 函式，執行 <code>printf</code>：</strong></p>
                        <ul>
                            <li><code>f_val</code> (在 <code>main</code> 中) 未被 <code>funC</code> 修改，仍為 2。</li>
                            <li><code>s_val</code> (在 <code>main</code> 中) 被 <code>funC</code> 透過指標修改為 40。</li>
                        </ul>
                        <p><code>printf("%4d%4d", f_val, s_val);</code> 會印出 "   2  40" (每個數字佔4個字元寬度)。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q12">下一題</button></div>
                </div>

                <div id="q12" class="quiz-card">
                    <h3>12. (原 Q38) 若要利用 C 語言寫一個 BMI 函式，此一函式接收傳入兩個整數資料，經計算後回傳的數值必須有小數點後至少兩位數精確度，BMI 函式的原型宣告應為下列何者？</h3>
                    <!-- No C code for this conceptual question -->
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) double BMI ( );</div>
                        <div class="option" data-option="B">(B) void BMI (int,int);</div>
                        <div class="option" data-option="C">(C) int BMI (int,int);</div>
                        <div class="option" data-option="D">(D) float BMI (int,int);</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：函式原型宣告</h4>
                        <p>函式原型宣告定義了函式的名稱、回傳型態以及其參數的型態和數量。</p>
                        <p>根據題目描述：</p>
                        <ul>
                            <li>函式名稱：BMI</li>
                            <li>接收傳入：兩個整數資料。這意味著參數列表應為 <code>(int, int)</code> 或類似的，例如 <code>(int height_cm, int weight_kg)</code>。</li>
                            <li>回傳的數值：必須有小數點後至少兩位數精確度。這表示回傳型態必須是浮點數型態，如 <code>float</code> 或 <code>double</code>。<code>double</code> 通常提供比 <code>float</code> 更高的精確度。</li>
                        </ul>
                        <p>分析選項：</p>
                        <ul>
                            <li><strong>(A) <code>double BMI ( );</code></strong>：回傳型態 <code>double</code> 合適，但參數列表為空，不符合「接收傳入兩個整數資料」的要求。</li>
                            <li><strong>(B) <code>void BMI (int,int);</code></strong>：參數列表 <code>(int,int)</code> 合適，但回傳型態 <code>void</code> 表示函式不回傳任何值，不符合「回傳的數值必須有小數點...」的要求。</li>
                            <li><strong>(C) <code>int BMI (int,int);</code></strong>：參數列表合適，但回傳型態 <code>int</code> 是整數，不符合回傳值需要小數精確度的要求。</li>
                            <li><strong>(D) <code>float BMI (int,int);</code></strong>：回傳型態 <code>float</code> 是浮點數，參數列表 <code>(int,int)</code> 接收兩個整數。這完全符合題目要求。使用 <code>double</code> 作為回傳型態 (<code>double BMI (int,int);</code>) 也會是正確的，並且通常是浮點運算的首選，但 <code>float</code> 也滿足「至少兩位數精確度」的基本要求。在給定選項中，(D) 是最合適的。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q13">下一題</button></div>
                </div>

                <div id="q13" class="quiz-card">
                    <h3>13. (原 Q39) 曉華寫了下列一段 C 語言程式...但發現無法成功進行編譯，應採取下列哪一個方案來解決這個問題？</h3>
                    <pre><code class="language-c">//1
                    //2 #include &lt;stdio.h&gt;
                    //3 //void sub(int i, char *s);
                    //4 int main(int argc, char *argv[]) {
                    //5   sub(argc, argv[2]);
                    //6   return 0;
                    //7 }
                    //8
                    //9 void sub(int i, char *s){
                    //10  printf("total %d arguments, and the 2nd one is %s\n", i, s);
                    //11 }
                    </code></pre>
                    <button class="run-example-btn" data-code-id="q13-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 將行號 4 中 main(int argc, char *argv[] )改為 main()</div>
                        <div class="option" data-option="B">(B) 去掉行號 3 最前面的註解標記//</div>
                        <div class="option" data-option="C">(C) 將行號 1 的 白行刪除</div>
                        <div class="option" data-option="D">(D) 在行號 1 新增#include &lt;stdlib.h&gt;</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：函式宣告 (原型)</h4>
                        <p>在 C 語言中，當一個函式被呼叫時，編譯器需要知道該函式的回傳型態和參數型態。這可以透過以下任一方式達成：</p>
                        <ol>
                            <li>函式的完整定義出現在呼叫它之前。</li>
                            <li>函式的宣告 (也稱為函式原型) 出現在呼叫它之前。</li>
                        </ol>
                        <p>在提供的程式碼中：</p>
                        <ul>
                            <li>函式 <code>sub</code> 在行號 5 被呼叫 (在 <code>main</code> 函式內部)。</li>
                            <li>函式 <code>sub</code> 的完整定義出現在行號 9-11，這是在 <code>main</code> 函式之後。</li>
                            <li>行號 3 <code>//void sub(int i, char *s);</code> 是一個被註解掉的函式原型。如果這個原型沒有被註解，它會告訴編譯器 <code>sub</code> 函式的簽名 (signature)。</li>
                        </ul>
                        <p>由於 <code>sub</code> 的定義在 <code>main</code> 之後，且其原型被註解掉了，編譯器在行號 5 遇到 <code>sub(...)</code> 呼叫時，不知道 <code>sub</code> 是什麼。這會導致編譯錯誤 (通常是關於隱式函式宣告的警告，或者在嚴格模式下是錯誤)。</p>
                        <p>分析選項：</p>
                        <ul>
                            <li><strong>(A) 將行號 4 中 main(int argc, char *argv[] )改為 main()：</strong> 這會改變 <code>main</code> 函式的簽名，使其無法接收命令列參數，但並不能解決 <code>sub</code> 函式未宣告的問題。</li>
                            <li><strong>(B) 去掉行號 3 最前面的註解標記//：</strong> 這會使 <code>void sub(int i, char *s);</code> 成為一個有效的函式原型。如此一來，編譯器在編譯 <code>main</code> 函式時，就知道 <code>sub</code> 函式的存在及其參數和回傳型態，即使完整定義在後面，也能正確編譯。這是正確的解決方案。</li>
                            <li><strong>(C) 將行號 1 的 白行刪除：</strong> 空白行對編譯沒有影響。</li>
                            <li><strong>(D) 在行號 1 新增#include &lt;stdlib.h&gt;：</strong> <code>&lt;stdlib.h&gt;</code> 提供了許多標準函式 (如記憶體管理、字串轉換等)，但它不包含使用者自訂函式 <code>sub</code> 的宣告。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q14">下一題</button></div>
                </div>

                <div id="q14" class="quiz-card">
                    <h3>14. (原 Q40) [閱讀題組 Q40-Q42] 曉華想要了解 C 語言程式區域變數(Local variable)和全域變數(Global variable)的數值變化情形，撰寫了下列的程式。下列何者為程式執行結果？</h3>
                    <pre><code class="language-c">//1 #include &lt;stdio.h&gt;
//2 int sum_g_q40=1, x_g_q40=10; // Renamed globals for clarity
//3 int inc_q40(int xin){
//4   int sum_local_inc=2;
//5   sum_local_inc = sum_local_inc + xin;
//6   xin++;
//7   return (sum_local_inc);
//8 }
//9 int main(void){ // Corrected main
//10  int sum_main = 3;
//11  sum_main=inc_q40(x_g_q40);
//12  printf("%d, %d\n", sum_main, x_g_q40); // Added newline
//13  return 0;
//14 }
</code></pre>
                    <button class="run-example-btn" data-code-id="q14-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 11, 11</div>
                        <div class="option" data-option="B">(B) 13, 10</div>
                        <div class="option" data-option="C">(C) 12, 11</div>
                        <div class="option" data-option="D">(D) 12, 10</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：變數範圍與傳值呼叫</h4>
                        <p>程式中有以下變數：</p>
                        <ul>
                            <li>行號 2: 全域變數 <code>sum_g_q40</code> (原 sum) = 1, 全域變數 <code>x_g_q40</code> (原 x) = 10.</li>
                            <li>行號 3: 函式 <code>inc_q40</code> 的參數 <code>xin</code> (傳值呼叫).</li>
                            <li>行號 4: 函式 <code>inc_q40</code> 的區域變數 <code>sum_local_inc</code> (原 sum) = 2.</li>
                            <li>行號 10: 函式 <code>main</code> 的區域變數 <code>sum_main</code> (原 sum) = 3.</li>
                        </ul>
                        <p>執行流程：</p>
                        <ol>
                            <li><code>main</code> 開始執行。<code>sum_main = 3</code>。全域 <code>x_g_q40 = 10</code>。</li>
                            <li>行號 11: <code>sum_main = inc_q40(x_g_q40);</code>
                                <ul>
                                    <li>呼叫 <code>inc_q40</code>，並將 <code>x_g_q40</code> (值為 10) 傳遞給參數 <code>xin</code>。所以 <code>xin = 10</code> (這是 <code>x_g_q40</code> 的副本)。</li>
                                    <li>在 <code>inc_q40</code> 內部：
                                        <ul>
                                            <li>行號 4: 區域變數 <code>sum_local_inc</code> 初始化為 2。</li>
                                            <li>行號 5: <code>sum_local_inc = sum_local_inc + xin;</code> → <code>sum_local_inc = 2 + 10 = 12</code>.</li>
                                            <li>行號 6: <code>xin++;</code> → <code>xin</code> 變為 11. (這是對 <code>inc_q40</code> 內的副本 <code>xin</code> 的修改，不影響 <code>main</code> 中的 <code>x_g_q40</code>)。</li>
                                            <li>行號 7: 回傳 <code>sum_local_inc</code> (值為 12).</li>
                                        </ul>
                                    </li>
                                    <li><code>sum_main</code> (在 <code>main</code> 中) 被賦值為 <code>inc_q40</code> 的回傳值，所以 <code>sum_main = 12</code>.</li>
                                </ul>
                            </li>
                            <li>行號 12: <code>printf("%d, %d", sum_main, x_g_q40);</code>
                                <ul>
                                    <li><code>sum_main</code> 的值是 12.</li>
                                    <li><code>x_g_q40</code> (全域變數) 的值從未被修改，仍為 10 (因為 <code>xin</code> 是傳值呼叫的副本)。</li>
                                </ul>
                            </li>
                        </ol>
                        <p>因此，輸出結果是 "12, 10"。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q15">下一題</button></div>
                </div>

                <div id="q15" class="quiz-card">
                    <h3>15. (原 Q41) [閱讀題組 Q40-Q42] 在執行到行號 12 的時候，想要讓 x 的值隨著行號 6 中 xin 的值更新，下列修改程式的方式何者正確？</h3>
                    <pre><code class="language-c">// Code context from Q14 (Original Q40)
//2 int sum_g_q40=1, x_g_q40=10;
//3 int inc_q40(int xin){
//...
//6   xin++;
//...
//11  sum_main=inc_q40(x_g_q40);
                    </code></pre>
                    <!-- No run button as this is conceptual -->
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 行號 11 的 x 改為&amp;x，並將函式 inc( )中所有的 xin 全部改為*xin</div>
                        <div class="option" data-option="B">(B) 行號 11 的 x 改為*x，並將函式 inc( )中所有的 xin 全部改為&amp;xin</div>
                        <div class="option" data-option="C">(C) 行號 11 的 x 改為&amp;x，並將函式 inc( )中所有的 xin 全部改為&amp;xin</div>
                        <div class="option" data-option="D">(D) 行號 11 的 x 改為*x，並將函式 inc( )中所有的 xin 全部改為*xin</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：實現傳址呼叫效果</h4>
                        <p>目前，在 Q40 的程式碼中，<code>x_g_q40</code> (原 x) 是以「傳值呼叫」方式傳遞給 <code>inc_q40</code> 函式的參數 <code>xin</code>。這意味著 <code>xin</code> 只是 <code>x_g_q40</code> 的一個副本，在 <code>inc_q40</code> 內部對 <code>xin</code> 的修改 (如行號 6 的 <code>xin++;</code>) 不會影響到 <code>main</code> 函式中的原始 <code>x_g_q40</code>。</p>
                        <p>為了讓 <code>main</code> 中的 <code>x_g_q40</code> 能被 <code>inc_q40</code> 函式修改，我們需要使用「傳址呼叫」的機制，即傳遞變數的記憶體位址 (使用指標)。</p>
                        <p>修改步驟：</p>
                        <ol>
                            <li><strong>修改函式呼叫 (行號 11):</strong>
                                <ul><li>在呼叫 <code>inc_q40</code> 時，需要傳遞 <code>x_g_q40</code> 的位址，而不是其值。這通過取址運算子 <code>&amp;</code> 來完成。所以呼叫變成 <code>inc_q40(&amp;x_g_q40)</code>。</li></ul>
                            </li>
                            <li><strong>修改函式定義 (行號 3) 和內部使用 (行號 5, 6):</strong>
                                <ul>
                                    <li>函式 <code>inc_q40</code> 的參數 <code>xin</code> 現在需要是一個指標，用來接收傳入的位址。所以參數宣告應改為 <code>int *xin</code>。</li>
                                    <li>在函式內部，要存取或修改 <code>xin</code> 所指向的記憶體位置的值 (即 <code>main</code> 中的 <code>x_g_q40</code>)，需要使用解參考運算子 <code>*</code>。
                                        <ul>
                                            <li>行號 5: <code>sum_local_inc = sum_local_inc + (*xin);</code> (使用 <code>xin</code> 指向的值)</li>
                                            <li>行號 6: <code>(*xin)++;</code> (對 <code>xin</code> 指向的值進行遞增)</li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ol>
                        <p>分析選項：</p>
                        <ul>
                            <li><strong>(A) 行號 11 的 x 改為 &amp;x，並將函式 inc( )中所有的 xin 全部改為 *xin：</strong>
                                <ul>
                                    <li>「行號 11 的 x 改為 &amp;x」 (應為 <code>&amp;x_g_q40</code>) 是正確的，傳遞位址。</li>
                                    <li>「函式 inc( )中所有的 xin 全部改為 *xin」：這指的是函式參數宣告變為 <code>int *xin</code> (這裡 "所有的 xin" 應理解為參數定義和其在函式體內的使用)。在函式體內使用時，要存取值用 <code>*xin</code>，要修改值用 <code>(*xin)++</code>。選項的描述 "所有的 xin 全部改為 *xin" 是指在使用 <code>xin</code> 的地方改為 <code>*xin</code> (或 `(*xin)++` for modification)。這與我們的修改步驟相符。</li>
                                </ul>
                            </li>
                            <li>(B), (C), (D) 都包含了不正確的組合，例如傳遞值卻在函式內用指標，或傳遞指標卻在函式內用值，或者錯誤地使用 <code>&amp;</code> 和 <code>*</code>。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q16">下一題</button></div>
                </div>

                <div id="q16" class="quiz-card">
                    <h3>16. (原 Q42) [閱讀題組 Q40-Q42] 關於行號 2、行號 4、以及行號 10 的變數 sum 的敘述，下列何者正確？</h3>
                    <pre><code class="language-c">// Code context from Q14 (Original Q40)
//1 #include &lt;stdio.h&gt;
//2 int sum_g_q40=1, x_g_q40=10; // Renamed global sum
//3 int inc_q40(int xin){
//4   int sum_local_inc=2; // Renamed local sum in inc
//5   sum_local_inc = sum_local_inc + xin;
//6   xin++;
//7   return (sum_local_inc);
//8 }
//9 int main(void){ // Corrected main
//10  int sum_main = 3; // Renamed local sum in main
//11  sum_main=inc_q40(x_g_q40);
//12  printf("%d, %d\n", sum_main, x_g_q40);
//13  return 0;
//14 }
                    </code></pre>
                    <!-- No run button as this is conceptual -->
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 行號 2 的 sum 是全域變數，行號 4 的 sum 是區域變數</div>
                        <div class="option" data-option="B">(B) 行號 2 的 sum 是區域變數，行號 4 的 sum 是全域變數</div>
                        <div class="option" data-option="C">(C) 行號 2 的 sum 和行號 10 的 sum 都是區域變數</div>
                        <div class="option" data-option="D">(D) 行號 2 的 sum 和行號 10 的 sum 都是全域變數</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：變數範圍 (Scope)</h4>
                        <p>變數的範圍決定了程式中哪些部分可以存取該變數。</p>
                        <ul>
                            <li><strong>全域變數 (Global Variable):</strong> 在所有函式之外宣告的變數。它們從宣告點開始到檔案結束都可見，並且可以被檔案中在其宣告之後的任何函式存取 (除非被同名的區域變數遮蔽)。</li>
                            <li><strong>區域變數 (Local Variable):</strong> 在函式內部或一個區塊 (block, 用 <code>{}</code> 界定) 內部宣告的變數。它們只在該函式或區塊內部可見。</li>
                        </ul>
                        <p>分析程式碼中的 <code>sum</code> 變數 (已在上面程式碼中為清楚起見加上後綴)：</p>
                        <ul>
                            <li><strong>行號 2 的 <code>sum_g_q40</code> (原 <code>sum</code>):</strong> <code>int sum_g_q40=1;</code>
                                <ul><li>這個 <code>sum</code> 是在所有函式 (<code>inc_q40</code> 和 <code>main</code>) 之外宣告的。因此，它是<strong>全域變數</strong>。</li></ul>
                            </li>
                            <li><strong>行號 4 的 <code>sum_local_inc</code> (原 <code>sum</code>):</strong> <code>int sum_local_inc=2;</code>
                                <ul><li>這個 <code>sum</code> 是在 <code>inc_q40</code> 函式內部宣告的。因此，它是 <code>inc_q40</code> 函式的<strong>區域變數</strong>。它會遮蔽 (hide) 全域的 <code>sum_g_q40</code> 在 <code>inc_q40</code> 函式內部的使用。</li></ul>
                            </li>
                            <li><strong>行號 10 的 <code>sum_main</code> (原 <code>sum</code>):</strong> <code>int sum_main = 3;</code>
                                <ul><li>這個 <code>sum</code> 是在 <code>main</code> 函式內部宣告的。因此，它是 <code>main</code> 函式的<strong>區域變數</strong>。它會遮蔽全域的 <code>sum_g_q40</code> 在 <code>main</code> 函式內部的使用。</li></ul>
                            </li>
                        </ul>
                        <p>對照選項：</p>
                        <ul>
                            <li><strong>(A) 行號 2 的 sum 是全域變數，行號 4 的 sum 是區域變數：</strong> 這是正確的。</li>
                            <li>(B) 行號 2 的 sum 是區域變數 (錯誤)，行號 4 的 sum 是全域變數 (錯誤)。</li>
                            <li>(C) 行號 2 的 sum (錯誤，是全域) 和行號 10 的 sum 都是區域變數 (行號 10 的 sum 是區域變數，但行號 2 的不是)。</li>
                            <li>(D) 行號 2 的 sum 和行號 10 的 sum 都是全域變數 (錯誤，行號 10 的 sum 是區域變數)。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q17">下一題</button></div>
                </div>

                <div id="q17" class="quiz-card">
                    <h3>17. (原 Q43) 針對任意實係數二次多項式 f(x) = ax^2 + bx + c...發現程式編譯錯誤，主要原因以及可以採取更正措施為下列何者？</h3>
                    <pre><code class="language-c">//1 #include &lt;stdio.h&gt;
//2 /* Potential place for global a, b, c */
//3 float f_q43(float x){ // Renamed
//4   // return(a*x*x+b*x+c); // Original line causing error
//5   // This line would cause error if a,b,c are not visible here
//    return 0; // Placeholder for runnable example
// }
//6 int main(void){ // Corrected main
//7   float x_val, a_val=1, b_val=0, c_val=-1; // Renamed
//8   // for(x_val=-10; x_val&lt;=10; x_val=x_val+0.1)
//9   //  printf("f(%.1f)=%.1f\n", x_val, f_q43(x_val));
//10}
                    </code></pre>
                    <button class="run-example-btn" data-code-id="q16-code">運行示例</button> <!-- Uses Q16's (orig Q43) runnable sample -->
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 變數 x, a, b, c 不可以宣告為 float，若宣告為 double 可以解決此問題</div>
                        <div class="option" data-option="B">(B) 變數 a, b, c 的初始值是整數，若改為包含小數位數的實數可以解決此問題</div>
                        <div class="option" data-option="C">(C) 變數 a, b, c 屬於 main()中的區域變數(Local Variable)，將變數 a, b, c 移到行號 2 宣告可以解決此問題</div>
                        <div class="option" data-option="D">(D) 變數 x, a, b, c 屬於全域變數(Global Variable)，改宣告為在函式 f ( )中的區域變數 (Local Variable)可以解決此問題</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：變數範圍 (Scope) 與可見性</h4>
                        <p>分析程式碼片段：</p>
                        <ul>
                            <li>行號 7: 在 <code>main</code> 函式中，宣告了區域變數 <code>float x, a=1, b=0, c=-1;</code>。這些變數 <code>a</code>, <code>b</code>, <code>c</code> 的作用域僅限於 <code>main</code> 函式內部。</li>
                            <li>行號 3-5: 函式 <code>f(float x)</code> (這裡改名為 <code>f_q43</code>) 試圖在其返回語句中使用變數 <code>a</code>, <code>b</code>, 和 <code>c</code>: <code>return(a*x*x+b*x+c);</code>。</li>
                        </ul>
                        <p><strong>編譯錯誤的原因：</strong></p>
                        <p>函式 <code>f_q43</code> 無法存取 <code>main</code> 函式中宣告的區域變數 <code>a</code>, <code>b</code>, <code>c</code>。因為這些變數的作用域只在 <code>main</code> 內部，對 <code>f_q43</code> 而言是不可見的。因此，當編譯器在 <code>f_q43</code> 中遇到未經宣告的 <code>a</code>, <code>b</code>, <code>c</code> 時，會報告錯誤 (通常是 "undeclared identifier" 或類似訊息)。</p>
                        <p>分析選項中的更正措施：</p>
                        <ul>
                            <li><strong>(A) 變數 x, a, b, c 不可以宣告為 float，若宣告為 double 可以解決此問題：</strong> 更改資料型態並不能解決變數作用域的問題。</li>
                            <li><strong>(B) 變數 a, b, c 的初始值是整數，若改為包含小數位數的實數可以解決此問題：</strong> 初始值的型態 (整數 vs. 浮點數) 與作用域問題無關。</li>
                            <li><strong>(C) 變數 a, b, c 屬於 main()中的區域變數(Local Variable)，將變數 a, b, c 移到行號 2 宣告可以解決此問題：</strong> 如果將 <code>a, b, c</code> 的宣告移到行號 2 (即所有函式之外)，它們就會成為全域變數。全域變數可以被同一檔案中的所有函式存取 (在其宣告之後)。這樣 <code>f_q43</code> 就能存取到 <code>a, b, c</code>，編譯錯誤會消失。這是正確的解決方案之一 (雖然使用全域變數有時不被鼓勵，但它能解決此特定編譯錯誤)。另一種常見的解決方案是將 <code>a,b,c</code> 作为参数传递给函数 <code>f</code>。</li>
                            <li><strong>(D) 變數 x, a, b, c 屬於全域變數(Global Variable)，改宣告為在函式 f ( )中的區域變數 (Local Variable)可以解決此問題：</strong> 題目中的 <code>a,b,c</code> (在 <code>main</code> 中) 不是全域變數。如果將它們改為在 <code>f</code> 中宣告為區域變數，那麼它們的值需要從 <code>main</code> 傳遞進來，或者 <code>f</code> 函式將無法使用 <code>main</code> 中設定的係數。這並不能解決 <code>f</code> 想要使用 <code>main</code> 中定義的 <code>a,b,c</code> 的問題。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q18">下一題</button></div>
                </div>

                <div id="q18" class="quiz-card">
                    <h3>18. (原 Q44) ...若變數 found 為 1 表示該範圍內存在 f(x)=0，則行號 11 內的 if 判斷式中，??可以為下列何者？</h3>
                    <pre><code class="language-c">//1 #include &lt;stdio.h&gt;
//2 float a=1, b=0, m=-11, n=12; // Global a,b,m,n
//3 float f(float x){
//4   return(a*x+b);
//5 }
//6 int main(void){ // Corrected
//7   float x; // Unused in this snippet
//8   unsigned char found=0;
//9   // scanf("%f",&amp;a); scanf("%f",&amp;b); // Values can be changed by user
//10  // scanf("%f",&amp;m); scanf("%f",&amp;n);
//11  if( (f(m) * f(n)) &lt;=0 ) // Placeholder for ?? from option (A)
//12    found = 1;
//13  // printf("f(m)=%.2f, f(n)=%.2f, f(m)*f(n)=%.2f\n", f(m), f(n), f(m)*f(n));
//14  printf("found=%d\n", found);
//15  return 0;
//16 }
                    </code></pre>
                    <!-- No run button as this is conceptual logic -->
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) f (m) * f (n)</div>
                        <div class="option" data-option="B">(B) f (m) + f (n)</div>
                        <div class="option" data-option="C">(C) f (m) – f (n)</div>
                        <div class="option" data-option="D">(D) f (m) % f (n)</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：中間值定理應用</h4>
                        <p>題目描述的是一個線性函式 <code>f(x) = ax + b</code>。我們要判斷在區間 <code>[m, n]</code>內是否存在一個 <code>x</code> 使得 <code>f(x) = 0</code> (即函式圖形與 x 軸有交點)。</p>
                        <p>根據<strong>中間值定理 (Intermediate Value Theorem)</strong>，如果一個連續函式 <code>f(x)</code> 在區間的兩個端點 <code>m</code> 和 <code>n</code> 上的函式值 <code>f(m)</code> 和 <code>f(n)</code> 符號相反 (一個正，一個負)，或者其中一個為 0，那麼在區間 <code>[m, n]</code> 內至少存在一個點 <code>c</code> 使得 <code>f(c) = 0</code>。</p>
                        <p>判斷 <code>f(m)</code> 和 <code>f(n)</code> 符號相反或其中之一為零的數學條件是：</p>
                        <p><code>f(m) * f(n) &lt;= 0</code></p>
                        <ul>
                            <li>如果 <code>f(m)</code> 和 <code>f(n)</code> 一正一負，則它們的乘積 <code>f(m) * f(n)</code> 會是負數 (< 0)。</li>
                            <li>如果 <code>f(m) = 0</code> 或 <code>f(n) = 0</code> (或兩者都為 0)，則它們的乘積 <code>f(m) * f(n)</code> 會是 0。</li>
                        </ul>
                        <p>所以，條件 <code>f(m) * f(n) &lt;= 0</code> 可以有效地判斷在區間 <code>[m, n]</code> (包含端點) 是否存在根。</p>
                        <p>分析選項：</p>
                        <ul>
                            <li><strong>(A) <code>f(m) * f(n)</code>：</strong> 如果 <code>f(m) * f(n) &lt;= 0</code>，則表示可能存在根。這是正確的判斷依據。</li>
                            <li>(B) <code>f(m) + f(n)</code>：兩函式值之和不能直接判斷是否存在根。例如，f(m)=1, f(n)=1，和為2，無根；f(m)=-1, f(n)=1，和為0，有根。</li>
                            <li>(C) <code>f(m) – f(n)</code>：兩函式值之差也不能直接判斷。</li>
                            <li>(D) <code>f(m) % f(n)</code>：取模運算通常用於整數，對於浮點數結果的函式 <code>f(x)</code> 不適用於此判斷。</li>
                        </ul>
                        <p>因此，行號 11 的 <code>??</code> 應該是 <code>f(m) * f(n)</code>，配合 <code>&lt;= 0</code> 的比較。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q19">下一題</button></div>
                </div>

                <div id="q19" class="quiz-card">
                    <h3>19. (原 Q45) [閱讀題組 Q45-Q46] ...程式輸出結果為何？</h3>
                    <pre><code class="language-c">// Code from question context (Q45-46)
//1 #include &lt;stdio.h&gt;
//2 #define N_Q45 11 // Renamed N to avoid conflict
//3 void swap_q45(int a, int b){ // Renamed
//4   int tmp; tmp=a; a=b; b=tmp;
//5 }
//9 int main(void){ // Corrected main
//10  int numbers[N_Q45]={1,3,5,7,9,2,4,6,8,0,'a'}; // 'a' is 97
//11  int tmp, i, min_idx; // Renamed min to min_idx
//13  for(min_idx=0; min_idx&lt;N_Q45; min_idx++)
//14    for(i=0; i&lt;N_Q45; i++){ // Inner loop always scans full array
//15      if(numbers[i]&lt;numbers[min_idx]){
//17        tmp=numbers[min_idx];
//18        numbers[min_idx]=numbers[i];
//19        numbers[i]=tmp;
//20      }
//21    }
//22  for(i=0; i&lt;N_Q45; i++){
//23    printf("%d ", numbers[i]);
//24  }
//25  printf("\n"); // Added for clarity
//26 return 0; }
                    </code></pre>
                    <button class="run-example-btn" data-code-id="q18-code">運行示例</button> <!-- Uses Q18's code (orig Q45) -->
                    <div class="quiz-options" data-correct="D"> <!-- Corrected based on trace -->
                        <div class="option" data-option="A">(A) a 9 8 7 6 5 4 3 2 1 0</div>
                        <div class="option" data-option="B">(B) 0 1 2 3 4 5 6 7 8 9 a</div>
                        <div class="option" data-option="C">(C) 97 9 8 7 6 5 4 3 2 1 0</div>
                        <div class="option" data-option="D">(D) 0 1 2 3 4 5 6 7 8 9 97</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：排序演算法分析</h4>
                        <p>陣列 <code>numbers</code> 初始化為 <code>{1,3,5,7,9,2,4,6,8,0,'a'}</code>。字元 <code>'a'</code> 的 ASCII 值是 97。</p>
                        <p>所以陣列實際為 <code>{1,3,5,7,9,2,4,6,8,0,97}</code>。</p>
                        <p>程式中的排序邏輯：</p>
                        <pre><code class="language-c">for(min_idx=0; min_idx&lt;N_Q45; min_idx++)
    for(i=0; i&lt;N_Q45; i++){
        if(numbers[i]&lt;numbers[min_idx]){
            tmp=numbers[min_idx];
            numbers[min_idx]=numbers[i];
            numbers[i]=tmp;
        }
    }</code></pre>
                        <p>這個巢狀迴圈的行為分析：</p>
                        <ul>
                            <li><strong>外迴圈 (<code>min_idx</code>):</strong> 從 0 到 N-1。這個 <code>min_idx</code> 代表目前要放置正確元素的位置。</li>
                            <li><strong>內迴圈 (<code>i</code>):</strong> 從 0 到 N-1。這個迴圈在每次外迴圈迭代時都會完整掃描整個陣列。</li>
                            <li><strong>比較與交換:</strong> 如果 <code>numbers[i]</code> 小於 <code>numbers[min_idx]</code>，則交換它們。</li>
                        </ul>
                        <p>讓我們追蹤幾次外迴圈的迭代：</p>
                        <p>初始: <code>{1,3,5,7,9,2,4,6,8,0,97}</code></p>
                        <p><strong>當 <code>min_idx = 0</code> (目標：使 <code>numbers[0]</code> 成為整個陣列中最小的元素):</strong></p>
                        <ul>
                            <li>內迴圈掃描整個陣列。每當找到比 <code>numbers[0]</code> 更小的元素時，就將其與 <code>numbers[0]</code> 交換。</li>
                            <li>i=0: numbers[0]=1. (numbers[0] < numbers[0] is false)</li>
                            <li>i=1: numbers[1]=3. (3 < 1 false)</li>
                            <li>...</li>
                            <li>i=5: numbers[5]=2. (2 < 1 false)</li>
                            <li>i=9: numbers[9]=0. (0 < 1 true). Swap numbers[0] (1) and numbers[9] (0).
                                Array: <code>{0,3,5,7,9,2,4,6,8,1,97}</code>. numbers[0] is now 0.</li>
                            <li>內迴圈繼續，但 <code>numbers[0]</code> (現在是0) 已經是最小的，不會再有 <code>numbers[i] < numbers[0]</code> 成立。</li>
                            <li>外迴圈 <code>min_idx=0</code> 結束後: <code>numbers[0]</code> 是 0。 Array: <code>{0,3,5,7,9,2,4,6,8,1,97}</code></li>
                        </ul>
                        <p><strong>當 <code>min_idx = 1</code> (目標：使 <code>numbers[1]</code> 成為 <code>numbers[1...N-1]</code> 中最小的，但由於內迴圈從0開始，它會重新比較整個陣列):</strong></p>
                        <ul>
                            <li>內迴圈掃描。 <code>numbers[1]</code> 目前是 3.</li>
                            <li>i=0: numbers[0]=0. (0 < 3 true). Swap numbers[1] (3) and numbers[0] (0).
                                Array: <code>{3,0,5,7,9,2,4,6,8,1,97}</code>. numbers[1] is now 0.</li>
                            <li>... (繼續掃描) ...</li>
                            <li>i=9: numbers[9]=1. (1 < 0 false, because numbers[1] is now 0).</li>
                            <li>這個邏輯是錯誤的 selection sort。它並不是將第 <code>min_idx</code> 個最小元素放到 <code>numbers[min_idx]</code>。
                                該演算法會將整個陣列排序為升序。
                                讓我們重新思考：每次外層迴圈固定 <code>min_idx</code>，內層迴圈會把所有小於 <code>numbers[min_idx]</code> 的 <code>numbers[i]</code> 都跟 <code>numbers[min_idx]</code> 交換。
                                這實際上是一種非常低效的排序，但最終結果會是升序排列。
                            </li>
                        </ul>
                        <p>由於演算法是將元素升序排列，陣列 <code>{1,3,5,7,9,2,4,6,8,0,97}</code> 排序後會變成 <code>{0,1,2,3,4,5,6,7,8,9,97}</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q20">下一題</button></div>
                </div>

                <div id="q20" class="quiz-card">
                    <h3>20. (原 Q46) [閱讀題組 Q45-Q46] ...錯誤訊息 expected ‘ int ’ but argument is of type ‘ int * ’，錯誤原因為何？</h3>
                    <pre><code class="language-c">// Code from Q45 context
//3 void swap(int a, int b){ ... } // Pass-by-value
//...
//16       //swap(numbers+i, numbers+min); // If this line is used
                    </code></pre>
                    <!-- No run button -->
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 行號 16 呼叫 swap()時，使用的引數資料型態與副程式不一致</div>
                        <div class="option" data-option="B">(B) 行號 16 的 numbers 是陣列指標，不能和整數 i, min 相加</div>
                        <div class="option" data-option="C">(C) 行號 10 的陣列宣告中，字元'a'和 swap(.)函式中的整數變數 a 名稱上有衝突</div>
                        <div class="option" data-option="D">(D) 行號 12 註解，導致 min 沒有初始值。</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：函式呼叫與型別匹配</h4>
                        <p>函式 <code>swap</code> 的定義 (行號 3-8) 是：<code>void swap(int a, int b)</code>。這表示它期望接收兩個 <code>int</code> 型態的參數。</p>
                        <p>如果行號 16 的註解被拿掉，呼叫會變成：<code>swap(numbers+i, numbers+min);</code></p>
                        <ul>
                            <li><code>numbers</code> 是 <code>int</code> 陣列。在表達式中，陣列名 <code>numbers</code> 會衰變 (decay) 為指向其第一個元素的指標，即 <code>int*</code>。</li>
                            <li><code>numbers+i</code> 是一個指標運算，結果是指向 <code>numbers[i]</code> 的位址，其型態是 <code>int*</code>。</li>
                            <li><code>numbers+min</code> 同樣是指向 <code>numbers[min]</code> 的位址，型態是 <code>int*</code>。</li>
                        </ul>
                        <p>所以，行號 16 的呼叫實際上是試圖以兩個 <code>int*</code> 型態的引數去呼叫一個期望接收兩個 <code>int</code> 型態參數的函式。</p>
                        <p>錯誤訊息 "expected ‘int’ but argument is of type ‘int *’" 指出：函式期望 (expected) 一個 <code>int</code> 型態的參數，但實際傳入的引數 (argument) 卻是 <code>int*</code> 型態。</p>
                        <p>分析選項：</p>
                        <ul>
                            <li><strong>(A) 行號 16 呼叫 swap()時，使用的引數資料型態與副程式不一致：</strong> 這是完全正確的。函式要 <code>int</code>，卻傳了 <code>int*</code>。</li>
                            <li>(B) 行號 16 的 numbers 是陣列指標，不能和整數 i, min 相加：指標可以和整數相加（指標算術），這是合法的。</li>
                            <li>(C) 行號 10 的陣列宣告中，字元'a'和 swap(.)函式中的整數變數 a 名稱上有衝突：變數作用域不同，不會有名稱衝突。</li>
                            <li>(D) 行號 12 註解，導致 min 沒有初始值：<code>min</code> 在行號 13 的 <code>for</code> 迴圈中被初始化 (<code>min=0</code>)。</li>
                        </ul>
                        <p>要正確地使用傳址交換，<code>swap</code> 函式應定義為 <code>void swap(int *a, int *b)</code>，並且呼叫時傳遞位址，例如 <code>swap(&amp;numbers[i], &amp;numbers[min_idx])</code>。但題目是分析現有 (傳值) <code>swap</code> 函式與行號 16 呼叫方式之間的衝突。</p>
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
                'q4-code': '#include <stdio.h>\nvoid swap(int a, int b){ int temp; temp = a; a = b; b = temp; }\nint main(void){\n    int a=10, b=20;\n    printf("Before swap: a = %d, b = %d\\n", a, b);\n    swap(a, b);\n    printf("After swap (no change in main): a = %d, b = %d\\n", a, b);\n    return 0;\n}',
                'q5-code': '#include <stdio.h>\nint f(int n){ if (n==1) return 1; else return f(n-1) + n - 1; }\nint main(void){ printf("f(4) = %d\\n", f(4)); return 0; }',
                'q6-code': '#include <stdio.h>\nint fibonacci(int n){ if (n==0 || n==1) return n; else return fibonacci(n-1)+fibonacci(n-2); }\nint main(void){ printf("fibonacci(6) = %d\\n", fibonacci(6)); return 0; }',
                'q7-code': '#include <stdio.h>\nint FunctionA(int x, int y){ if (y==0) return 1; if (y==1) return x; else return (x * FunctionA(x,y-1)); }\nint main(void){ int c=FunctionA(3,6); printf("%d\\n", c); return 0; }',
                'q8-code': '#include <stdio.h>\nint f_q33(int a[], int n){\n    int index = 0;\n    for (int i=1; i<n; i=i+1){ if (a[i] >= a[index]){ index = i; } }\n    return index;\n}\nint main(void) {\n    int a[9]={1,2,3,4,7,5,9,6,8};\n    int ret=0; ret=f_q33(a, 9);\n    printf("%d\\n", ret);\n    return 0;\n}',
                'q9-code': '#include <stdio.h>\nint s_q34=1;\nvoid add_q34(int a){ s_q34 = s_q34+a; printf("%d ", s_q34); }\nint main(void) {\n    int s=10;\n    printf("%d ", s);\n    add_q34(s);\n    printf("%d\\n", s);\n    printf("Global s_q34 after call: %d\\n", s_q34);\n    return 0;\n}',
                'q10-code': '#include <stdio.h>\nint s_global_q35=1;\nvoid add_q35(int a){ int s_local_in_add=1; s_local_in_add = s_local_in_add+a; printf("%d ", s_local_in_add); }\nint main(void) {\n    int s_main=10;\n    add_q35(s_main);\n    add_q35(s_main);\n    printf("\\nUnaffected global s_global_q35: %d\\n", s_global_q35);\n    return 0;\n}',
                'q11-code': '#include <stdio.h>\nvoid funC(int* o, int q){ int p=5; q=3+p; *o=p*q; }\nint main(void) {\n    int f_val=2, s_val=3;\n    printf("Before: f_val=%d, s_val=%d\\n", f_val, s_val);\n    funC(&s_val, f_val);\n    printf("After: f_val=%4d, s_val=%4d\\n", f_val, s_val);\n    return 0;\n}',
                'q13-code': '#include <stdio.h>\n/* void sub_q39(int i, char *s); Prototype would go here */\nvoid sub_q39(int i, char *s){\n    printf("total %d arguments, and the 2nd one is %s\\n", i, s);\n}\nint main(int argc, char *argv[]) {\n    printf("Demonstrating Q39: Call to sub_q39\\n");\n    if (argc > 2) { \n        sub_q39(argc, argv[2]);\n    } else {\n        printf("Not enough command line arguments for argv[2].\\n");\n        if (argc > 1) sub_q39(argc,argv[1]); else if (argc > 0) sub_q39(argc, argv[0]);\n    }\n    return 0;\n}',
                'q14-code': '#include <stdio.h>\nint sum_g_q40=1, x_g_q40=10;\nint inc_q40(int xin){\n    int sum_local_inc=2;\n    sum_local_inc = sum_local_inc + xin;\n    xin++; \n    return (sum_local_inc);\n}\nint main(void){\n    int sum_main= 3;\n    sum_main=inc_q40(x_g_q40);\n    printf("%d, %d\\n", sum_main, x_g_q40);\n    return 0;\n}',
                'q17-code': '#include <stdio.h>\n/* float g_a_q43=1, g_b_q43=0, g_c_q43=-1; // Option 1: Globals */ \nfloat f_q43_params(float x, float param_a, float param_b, float param_c){\n    return(param_a*x*x + param_b*x + param_c);\n}\nint main(void){\n    float x_val;\n    float local_a=1, local_b=0, local_c=-1;\n    printf("Corrected by passing params a,b,c to f_q43_params:\\n");\n    for(x_val=-2; x_val<=2; x_val=x_val+1.0) {\n        printf("f(%.1f)=%.1f\\n", x_val, f_q43_params(x_val, local_a, local_b, local_c));\n    }\n    return 0;\n}',
                'q18-code': '#include <stdio.h>\n#define N_Q45 11\nint main(void){\n    int numbers[N_Q45]={1,3,5,7,9,2,4,6,8,0,\'a\'};\n    int tmp, i, min_idx;\n    printf("Original: "); for(i=0; i<N_Q45; i++) printf("%d ", numbers[i]); printf("\\n");\n    for(min_idx=0; min_idx<N_Q45; min_idx++) {\n        for(i=0; i<N_Q45; i++){\n            if(numbers[i]<numbers[min_idx]){\n                tmp=numbers[min_idx];\n                numbers[min_idx]=numbers[i];\n                numbers[i]=tmp;\n            }\n        }\n    }\n    printf("Sorted (ascending by current logic): ");\n    for(i=0; i<N_Q45; i++){ printf("%d ", numbers[i]); }\n    printf("\\n");\n    return 0;\n}'
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
