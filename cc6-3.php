<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C 語言 函式與進階應用 (cc6-3) - Corrected</title>

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
                <h2>第六章 互動練習題組 (3/?)</h2>
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
int main(void){
    int c=TestYou(2,7);
    printf("%d\n", c);
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
#include &lt;math.h&gt;
int main(void){
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
                        <p>函式 <code>round(x)</code> 會將浮點數 <code>x</code> 四捨五入到最接近的整數。</p>
                        <p>陣列 <code>dataB = {2.2, 2.8, -2.4, -1.8}</code>。</p>
                        <p>追蹤 <code>result</code> 的變化：</p>
                        <table>
                            <thead><tr><th>j</th><th>dataB[j]</th><th>round(dataB[j])</th><th>result (累計)</th></tr></thead>
                            <tbody>
                                <tr><td>-</td><td>-</td><td>-</td><td>0 (初始)</td></tr>
                                <tr><td>0</td><td>2.2</td><td>2</td><td>0 + 2 = 2</td></tr>
                                <tr><td>1</td><td>2.8</td><td>3</td><td>2 + 3 = 5</td></tr>
                                <tr><td>2</td><td>-2.4</td><td>-2</td><td>5 + (-2) = 3</td></tr>
                                <tr><td>3</td><td>-1.8</td><td>-2</td><td>3 + (-2) = 1</td></tr>
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
    if (n/10 != 0){
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
void swap(int a, int b){
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
                        <p>C 語言預設使用「傳值呼叫」。<code>swap</code> 函式內部對其參數 <code>a</code> 和 <code>b</code> (它們是 <code>main</code> 中 <code>a</code> 和 <code>b</code> 的副本) 的交換，不會影響 <code>main</code> 函式中的原始變數。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q5">下一題</button></div>
                </div>

                <div id="q5" class="quiz-card">
                    <h3>5. (原 Q30) 下列程式片段中，f(4)的輸出應該為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
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
                            <li><code>f(4)</code> → <code>f(3) + 3</code></li>
                            <li><code>f(3)</code> → <code>f(2) + 2</code></li>
                            <li><code>f(2)</code> → <code>f(1) + 1</code></li>
                            <li><code>f(1)</code> → 1</li>
                        </ul>
                        <p>回代：<code>f(2)</code>=1+1=2; <code>f(3)</code>=2+2=4; <code>f(4)</code>=4+3=7.</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q6">下一題</button></div>
                </div>

                <div id="q6" class="quiz-card">
                    <h3>6. (原 Q31) 呼叫下列的函式，fibonacci(6)答案為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
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
                        <p>F(0)=0, F(1)=1, F(2)=1, F(3)=2, F(4)=3, F(5)=5, F(6)=8.</p>
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
int main(void){
    int c=FunctionA(3,6);
    printf("%d\n", c);
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
                        <p>函式 <code>FunctionA(x, y)</code> 計算 x<sup>y</sup>. <code>FunctionA(3,6)</code> = 3<sup>6</sup> = 729.</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q8">下一題</button></div>
                </div>

                <div id="q8" class="quiz-card">
                    <h3>8. (原 Q33) 有一程式如下所示，執行後，顯示值為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int f_q33(int a[], int n){
    int index = 0;
    for (int i=1; i&lt;n; i=i+1){
        if (a[i] &gt;= a[index]){
            index = i;
        }
    }
    return index;
}
int main(void) {
    int a[9]={1,2,3,4,7,5,9,6,8};
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
                        <p>函式 <code>f_q33</code> 尋找陣列中最大元素的索引（若是多個最大值，則為最後一個出現的）。</p>
                        <p>陣列 <code>a = {1,2,3,4,7,5,9,6,8}</code>. 最大值是 9，其索引是 6。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q9">下一題</button></div>
                </div>

                <div id="q9" class="quiz-card">
                    <h3>9. (原 Q34) 下列程式執行結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int s_q34=1;
void add_q34(int);
int main(void) {
    int s=10;
    printf("%d ", s);
    add_q34(s);
    printf("%d\n", s);
    return 0;
}
void add_q34(int a){
    s_q34 = s_q34+a;
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
                        <p>1. <code>main</code> 中的 <code>s</code> (區域) = 10. 印出 "10 ".<br>2. 呼叫 <code>add_q34(10)</code>. <code>add_q34</code> 修改全域 <code>s_q34</code> (原 s). <code>s_q34 = 1 + 10 = 11</code>. 印出 "11 ".<br>3. 回到 <code>main</code>. <code>main</code> 中的區域 <code>s</code> 未變，仍為 10. 印出 "10".<br>總輸出: "10 11 10".</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q10">下一題</button></div>
                </div>

                <div id="q10" class="quiz-card">
                    <h3>10. (原 Q35) 下列程式執行結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int s_global_q35=1;
void add_q35(int);
int main(void) {
    int s_main=10;
    add_q35(s_main);
    add_q35(s_main);
    printf("\n");
    return 0;
}
void add_q35(int a){
    int s_local_in_add=1;
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
                        <h4>✓ 解題思路：變數範圍 (區域變數遮蔽)</h4>
                        <p><code>add_q35</code> 函式中的 <code>s_local_in_add</code> (原 s) 是區域變數，每次呼叫時都重新初始化為 1。它遮蔽了全域 <code>s_global_q35</code>。</p>
                        <p>1. 第一次 <code>add_q35(10)</code>: <code>s_local_in_add = 1 + 10 = 11</code>. 印出 "11 ".<br>2. 第二次 <code>add_q35(10)</code>: <code>s_local_in_add</code> 再次初始化為 1. <code>s_local_in_add = 1 + 10 = 11</code>. 印出 "11 ".<br>總輸出: "11 11 ".</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q11">下一題</button></div>
                </div>

                <div id="q11" class="quiz-card">
                    <h3>11. (原 Q36) 請問下列程式執行後，輸出的數值是？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
void funC(int* o, int q){
    int p=5;
    q=3+p;
    *o=p*q;
}
int main(void) {
    int f_val=2, s_val=3;
    funC(&amp;s_val, f_val);
    printf("%4d%4d\n", f_val, s_val);
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
                        <p>1. <code>main</code>: <code>f_val=2, s_val=3</code>.<br>2. <code>funC(&amp;s_val, f_val)</code>: <code>o</code> 指向 <code>s_val</code>, <code>q</code> 是 <code>f_val</code> 的副本 (<code>q=2</code>).<br>3. <code>funC</code> 內: <code>p=5</code>. <code>q = 3+5 = 8</code> (<code>funC</code>的<code>q</code>變了, <code>main</code>的<code>f_val</code>不變). <code>*o = p*q = 5*8 = 40</code> (<code>main</code>的<code>s_val</code>變成40).<br>4. <code>printf</code>: 印出 <code>f_val</code> (2) 和 <code>s_val</code> (40).</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q12">下一題</button></div>
                </div>

                <div id="q12" class="quiz-card">
                    <h3>12. (原 Q38) 若要利用 C 語言寫一個 BMI 函式...原型宣告應為下列何者？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) double BMI ( );</div>
                        <div class="option" data-option="B">(B) void BMI (int,int);</div>
                        <div class="option" data-option="C">(C) int BMI (int,int);</div>
                        <div class="option" data-option="D">(D) float BMI (int,int);</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：函式原型宣告</h4>
                        <p>接收兩個整數，回傳有小數精確度的值。<code>float</code> 或 <code>double</code> 回傳型態皆可。參數為 <code>(int, int)</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q13">下一題</button></div>
                </div>

                <div id="q13" class="quiz-card">
                    <h3>13. (原 Q39) 曉華寫了下列一段 C 語言程式...無法成功進行編譯，應採取下列哪一個方案來解決？</h3>
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
                        <p>函式 <code>sub</code> 在 <code>main</code> 之後定義，且其原型在行號 3 被註解。取消註解行號 3 可解決編譯錯誤。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q14">下一題</button></div>
                </div>

                <div id="q14" class="quiz-card">
                    <h3>14. (原 Q40) [閱讀題組 Q40-Q42] ...下列何者為程式執行結果？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int sum_g_q40=1, x_g_q40=10;
int inc_q40(int xin){
  int sum_local_inc=2;
  sum_local_inc = sum_local_inc + xin;
  xin++;
  return (sum_local_inc);
}
int main(void){
  int sum_main = 3;
  sum_main=inc_q40(x_g_q40);
  printf("%d, %d\n", sum_main, x_g_q40);
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q14-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 11, 11</div>
                        <div class="option" data-option="B">(B) 13, 10</div>
                        <div class="option" data-option="C">(C) 12, 11</div>
                        <div class="option" data-option="D">(D) 12, 10</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：變數範圍與傳值呼叫</h4>
                        <p>1. <code>main</code>: <code>sum_main = 3</code>, 全域 <code>x_g_q40 = 10</code>.<br>2. <code>inc_q40(x_g_q40)</code>: <code>xin=10</code> (副本). <code>sum_local_inc = 2+10 = 12</code>. <code>xin</code> 變為 11 (副本改變). 回傳 12.<br>3. <code>main</code>: <code>sum_main</code> 變為 12. 全域 <code>x_g_q40</code> 未變 (仍為 10).<br>4. <code>printf</code>: 印出 "12, 10".</p>
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
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 行號 11 的 x 改為&amp;x，並將函式 inc( )中所有的 xin 全部改為*xin</div>
                        <div class="option" data-option="B">(B) 行號 11 的 x 改為*x，並將函式 inc( )中所有的 xin 全部改為&amp;xin</div>
                        <div class="option" data-option="C">(C) 行號 11 的 x 改為&amp;x，並將函式 inc( )中所有的 xin 全部改為&amp;xin</div>
                        <div class="option" data-option="D">(D) 行號 11 的 x 改為*x，並將函式 inc( )中所有的 xin 全部改為*xin</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：實現傳址呼叫效果</h4>
                        <p>要修改 <code>main</code> 中的 <code>x_g_q40</code>，需傳遞其位址給 <code>inc_q40</code>，並在函式內使用指標操作。</p>
                        <p>1. 呼叫時: <code>inc_q40(&amp;x_g_q40)</code>.<br>2. 函式定義: <code>int inc_q40(int *xin)</code>.<br>3. 函式內部: 使用 <code>*xin</code> 存取值，<code>(*xin)++</code> 修改值。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q16">下一題</button></div>
                </div>

                <div id="q16" class="quiz-card">
                    <h3>16. (原 Q42) [閱讀題組 Q40-Q42] 關於行號 2、行號 4、以及行號 10 的變數 sum 的敘述，下列何者正確？</h3>
                    <pre><code class="language-c">// Code context from Q14 (Original Q40)
//2 int sum_g_q40=1, x_g_q40=10;
//3 int inc_q40(int xin){
//4   int sum_local_inc=2;
// ...
//9 int main(void){
//10  int sum_main = 3;
// ...
                    </code></pre>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 行號 2 的 sum 是全域變數，行號 4 的 sum 是區域變數</div>
                        <div class="option" data-option="B">(B) 行號 2 的 sum 是區域變數，行號 4 的 sum 是全域變數</div>
                        <div class="option" data-option="C">(C) 行號 2 的 sum 和行號 10 的 sum 都是區域變數</div>
                        <div class="option" data-option="D">(D) 行號 2 的 sum 和行號 10 的 sum 都是全域變數</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：變數範圍 (Scope)</h4>
                        <p>行號 2 的 <code>sum_g_q40</code> (原 sum) 在所有函式外宣告，是全域變數。<br>行號 4 的 <code>sum_local_inc</code> (原 sum) 在 <code>inc_q40</code> 函式內宣告，是該函式的區域變數。<br>行號 10 的 <code>sum_main</code> (原 sum) 在 <code>main</code> 函式內宣告，是 <code>main</code> 的區域變數。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q17">下一題</button></div>
                </div>

                <div id="q17" class="quiz-card">
                    <h3>17. (原 Q43) ...程式編譯錯誤，主要原因以及可以採取更正措施為下列何者？</h3>
                    <pre><code class="language-c">//1 #include &lt;stdio.h&gt;
//2
//3 float f_q43(float x){ // Renamed
//4   // return(a*x*x+b*x+c); // Error: a,b,c undefined here
//5   return 0; // Placeholder
// }
//6 int main(void){
//7   float x_val, a_val=1, b_val=0, c_val=-1;
//8   // ...
//9   //  printf("f(%.1f)=%.1f\n", x_val, f_q43(x_val));
//10}
                    </code></pre>
                    <button class="run-example-btn" data-code-id="q17-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 變數 x, a, b, c 不可以宣告為 float...</div>
                        <div class="option" data-option="B">(B) 變數 a, b, c 的初始值是整數...</div>
                        <div class="option" data-option="C">(C) 變數 a, b, c 屬於 main()中的區域變數...將變數 a, b, c 移到行號 2 宣告...</div>
                        <div class="option" data-option="D">(D) 變數 x, a, b, c 屬於全域變數...</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：變數範圍 (Scope) 與可見性</h4>
                        <p>函式 <code>f_q43</code> (原 f) 試圖使用 <code>a, b, c</code>，但這些變數在 <code>main</code> 中宣告為區域變數，對 <code>f_q43</code> 不可見。將 <code>a, b, c</code> 宣告為全域變數 (如移到行號 2) 或將它們作為參數傳遞給 <code>f_q43</code> 可以解決此問題。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q18">下一題</button></div>
                </div>

                <div id="q18" class="quiz-card">
                    <h3>18. (原 Q44) ...若變數 found 為 1 表示該範圍內存在 f(x)=0，則行號 11 內的 if 判斷式中，??可以為下列何者？</h3>
                    <pre><code class="language-c">// Context: f(x) = ax + b
//11  if( (f(m) * f(n)) &lt;=0 ) // from Option A
//12    found = 1;
                    </code></pre>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) f (m) * f (n)</div>
                        <div class="option" data-option="B">(B) f (m) + f (n)</div>
                        <div class="option" data-option="C">(C) f (m) – f (n)</div>
                        <div class="option" data-option="D">(D) f (m) % f (n)</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：中間值定理應用</h4>
                        <p>如果連續函式 <code>f(x)</code> 在區間端點 <code>m</code> 和 <code>n</code> 的函式值 <code>f(m)</code> 和 <code>f(n)</code> 異號或其中之一為零，則它們的乘積 <code>f(m) * f(n)</code> 會小於或等於零，表示區間 <code>[m, n]</code> 內至少存在一個根。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q19">下一題</button></div>
                </div>

                <div id="q19" class="quiz-card">
                    <h3>19. (原 Q44) 針對任意實係數一次多項式 f (x) = ax + b，曉華想要計算當 x 落在[m, n]範圍內時是否存在 f (x) = 0，寫了如下的 C 語言程式，若變數 found 為 1 表示該範圍內存在 f (x) = 0，則行號 11 內的 if 判斷式中，??可以為下列何者？</h3>
                    <pre><code class="language-c">
//1 #include &lt;stdio.h&gt;
//2 float a=1, b=0, m=-11, n=12;
//3 float f(float x){
//4   return(a*x+b);
//5 }
//6 int main(void){ // Corrected
//7   float x_val; // Renamed for clarity in sample
//8   unsigned char found=0;
//9   /* scanf("%f",&amp;a); scanf("%f",&amp;b); */
//10  /* scanf("%f",&amp;m); scanf("%f",&amp;n); */
//11  if( (f(m) * f(n)) &lt;=0 ) /* Substituting ?? with option A's content */
//12    found = 1;
//13  printf("found=%d\n", found);
//14  return 0;
//15 }
                    </code></pre>
                    <!-- This question is conceptual and directly reuses the context of Q18.
                         No separate run button or codeSample is typically needed if Q18 covers the logic.
                         However, if a runnable example is desired for Q44 itself, it would be the same as Q18's.
                         For now, marking as conceptual based on previous handling.
                    -->
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) f (m) * f (n)</div>
                        <div class="option" data-option="B">(B) f (m) + f (n)</div>
                        <div class="option" data-option="C">(C) f (m) – f (n)</div>
                        <div class="option" data-option="D">(D) f (m) % f (n)</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：中間值定理應用</h4>
                        <p>這與上一個問題 (原 Q44，此處重新標號為 Q18) 的邏輯相同。題目描述的是一個線性函式 <code>f(x) = ax + b</code>。我們要判斷在區間 <code>[m, n]</code>內是否存在一個 <code>x</code> 使得 <code>f(x) = 0</code>。</p>
                        <p>根據<strong>中間值定理 (Intermediate Value Theorem)</strong>，如果一個連續函式 <code>f(x)</code> 在區間的兩個端點 <code>m</code> 和 <code>n</code> 上的函式值 <code>f(m)</code> 和 <code>f(n)</code> 符號相反 (一個正，一個負)，或者其中一個為 0，那麼在區間 <code>[m, n]</code> 內至少存在一個點 <code>c</code> 使得 <code>f(c) = 0</code>。</p>
                        <p>判斷 <code>f(m)</code> 和 <code>f(n)</code> 符號相反或其中之一為零的數學條件是：</p>
                        <p><code>f(m) * f(n) &lt;= 0</code></p>
                        <p>因此，行號 11 的 <code>??</code> 應該是 <code>f(m) * f(n)</code>，配合 <code>&lt;= 0</code> 的比較。</p>
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
                'q17-code': '#include <stdio.h>\n/* float g_a_q43=1, g_b_q43=0, g_c_q43=-1; // Option 1: Globals */ \nfloat f_q43_params(float x, float param_a, float param_b, float param_c){\n    return(param_a*x*x + param_b*x + param_c);\n}\nint main(void){\n    float x_val;\n    float local_a=1, local_b=0, local_c=-1;\n    printf("Corrected by passing params a,b,c to f_q43_params:\\n");\n    for(x_val=-2; x_val<=2; x_val=x_val+1.0) {\n        printf("f(%.1f)=%.1f\\n", x_val, f_q43_params(x_val, local_a, local_b, local_c));\n    }\n    return 0;\n}'
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
