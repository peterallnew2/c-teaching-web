<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C 語言 函式與遞迴 (cc6-1) - Corrected</title>

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
            --primary-color: #4a90e2; /* A slightly more vibrant blue */
            --background-color: #1e1e1e; /* Dark background for editor-like feel */
            --text-color: #dcdcdc; /* Light grey for text, good contrast on dark */
            --header-color: #ffffff; /* White for main headers */
            --card-bg: #2d2d2d; /* Slightly lighter dark for cards */
            --border-color: #444; /* Subtle border color */
            --code-bg: #282c34; /* Common dark code editor background */
            --success-color: #73c990; /* Green for correct answers */
            --error-color: #f47174; /* Red for incorrect answers */
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
            min-width: 350px; /* Minimum width for tutorial content */
            padding: 20px 40px; /* More padding for better readability */
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
            min-width: 420px; /* Minimum width for interactive panel */
            flex-grow: 1;
            position: relative;
            height: 100vh;
            padding: 20px;
            box-sizing: border-box;
            display: flex; /* To allow inner content to flex */
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
        code:not(pre > code) { /* Inline code */
            background-color: var(--card-bg);
            color: var(--primary-color);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: var(--font-code);
        }
        pre { /* Code blocks */
            margin: 0.8em 0;
            padding: 10px;
            background-color: var(--code-bg);
            border-radius: 4px;
            overflow-x: auto;
            font-size: 0.85em;
        }
        /* Explanation specific styles */
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
        .explanation td code { /* Inline code within explanation tables */
             background-color: rgba(255,255,255,0.1); /* Slightly different bg for distinction */
             padding: 1px 4px;
             border-radius: 3px;
        }
        .explanation pre { /* Preformatted text within explanations (not full code blocks) */
            margin: 0.5em 0;
            padding: 8px;
            background-color: rgba(0,0,0,0.2); /* Darker, less prominent than main code blocks */
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .explanation .code-block-within-explanation pre { /* For actual C code within an explanation */
             background-color: var(--code-bg); /* Same as main code blocks */
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
            background-color: #357ABD; /* Darker shade of primary for hover */
        }
        /* Interactive Panel (Sandbox) */
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
            background-color: #5aa777; /* Darker green */
        }
        #run-code-btn:disabled {
            background-color: #555;
            cursor: not-allowed;
        }
        #output-area {
            background-color: #000; /* Black for output, classic terminal feel */
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            font-family: var(--font-code);
            white-space: pre-wrap;
            word-wrap: break-word;
            min-height: 80px; /* Min height to be always visible */
            margin-top: 8px;
            flex-shrink: 0;
            font-size: 0.85em;
            overflow-y: auto;
            max-height: 250px; /* Max height before scrolling */
        }
        /* Quiz Card Styling */
        .quiz-section {
            margin-top: 20px;
            background-color: transparent; /* No card background for the section itself */
            border: none;
            padding: 0;
        }
        .quiz-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            scroll-margin-top: 20px; /* For "Next" button scrolling */
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
            background-color: #3c3c3c; /* Darker grey for options */
            margin: 8px 0;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            border: 2px solid transparent; /* For feedback */
            transition: border-color 0.3s, background-color 0.3s;
            position: relative; /* For feedback icon positioning */
            font-size: 0.9em;
        }
        .quiz-options .option:hover {
            border-color: var(--primary-color);
        }
        .quiz-options .option.correct {
            border-color: var(--success-color);
            background-color: rgba(115, 201, 144, 0.15); /* Light green tint */
        }
        .quiz-options .option.incorrect {
            border-color: var(--error-color);
            background-color: rgba(244, 113, 116, 0.15); /* Light red tint */
        }
        .quiz-options .option.answered { /* General style for any answered option */
            cursor: default;
        }
        .quiz-options .option.answered:hover { /* Prevent hover effect on answered options */
            border-color: currentColor; /* Keep current border color (correct/incorrect) */
        }
        .quiz-options .option.correct.answered:hover {
             border-color: var(--success-color);
        }
         .quiz-options .option.incorrect.answered:hover {
             border-color: var(--error-color);
        }
        .feedback-icon { /* For checkmark or X */
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.1em;
        }

        .explanation {
            display: none; /* Initially hidden */
            margin-top: 15px;
            padding: 15px;  /* More padding within explanation */
            background-color: rgba(0,0,0,0.1); /* Slightly transparent dark bg */
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
            padding-left: 20px; /* Standard padding for lists */
            margin-bottom: 10px;
        }
        .explanation ul li::marker { /* Style list markers if needed */
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
        /* For any specific code block before questions if needed */
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
            <h1>C 語言練習：第六章 - 函式、遞迴與參數傳遞</h1>
            <p>本頁面為 C/C++ 語言第六章練習題 (第 1-25 題)。此章節著重於函式的定義與呼叫、遞迴的觀念與應用、參數傳遞方式 (傳值、傳址) 的理解，以及相關的標準函式庫使用。請仔細分析每個問題，並利用右側的沙箱進行實作與驗證。</p>

            <div class="quiz-section">
                <h2>第六章 互動練習題組 (1/1)</h2>
                <p>請挑戰下面的題目，檢驗您的學習成果！</p>
                <!-- QUIZ CARDS START (Content identical to previous version, only JS below is 'fixed') -->
                <div id="q1" class="quiz-card">
                    <h3>1. 下列是一個用 C 的語法寫成的程式，請問程式執行結束時，變數 value 之值為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt; // Added for printf in example
void swap(int *a, int *b){
    int t;
    t=*a;
    *a=*b;
    *b=t;
}
int main(void){ // Corrected from void main
    int value=1, list[5]={0,2,4,6,8};
    // Optional: Print initial state for clarity in example
    // printf("Initial: value=%d, list={%d,%d,%d,%d,%d}\n", value, list[0],list[1],list[2],list[3],list[4]);

    swap(&amp;list[2],&amp;list[3]);
    // printf("After swap1: value=%d, list[2]=%d, list[3]=%d\n", value, list[2], list[3]);

    swap(&amp;value,&amp;list[3]);
    // printf("After swap2: value=%d, list[3]=%d\n", value, list[3]);

    // Critical step: list[value] uses the *current* value of 'value' as index
    swap(&amp;value,&amp;list[value]);
    // printf("After swap3: value=%d, list now potentially modified at list[%d]\n", value, list[value]); // Be careful if value changed

    // The question asks for final 'value'
    // printf("Final value: %d\n", value);
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q1-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 1</div>
                        <div class="option" data-option="B">(B) 4</div>
                        <div class="option" data-option="C">(C) 6</div>
                        <div class="option" data-option="D">(D) 8</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路與變數追蹤</h4>
                        <p>我們需要逐步追蹤變數 <code>value</code> 和陣列 <code>list</code> 的變化。</p>
                        <p><strong>初始狀態：</strong></p>
                        <ul>
                            <li><code>value = 1</code></li>
                            <li><code>list = {0, 2, 4, 6, 8}</code> (即 <code>list[0]=0, list[1]=2, list[2]=4, list[3]=6, list[4]=8</code>)</li>
                        </ul>
                        <p><strong>第一次交換：<code>swap(&amp;list[2], &amp;list[3]);</code></strong></p>
                        <ul>
                            <li>交換 <code>list[2]</code> (值為 4) 和 <code>list[3]</code> (值為 6)。</li>
                            <li>之後：<code>list[2] = 6</code>, <code>list[3] = 4</code>。</li>
                            <li><code>value</code> 仍為 1。</li>
                            <li><code>list</code> 變為 <code>{0, 2, 6, 4, 8}</code>。</li>
                        </ul>
                        <p><strong>第二次交換：<code>swap(&amp;value, &amp;list[3]);</code></strong></p>
                        <ul>
                            <li>交換 <code>value</code> (值為 1) 和 <code>list[3]</code> (目前值為 4)。</li>
                            <li>之後：<code>value = 4</code>, <code>list[3] = 1</code>。</li>
                            <li><code>list</code> 變為 <code>{0, 2, 6, 1, 8}</code>。</li>
                        </ul>
                        <p><strong>第三次交換：<code>swap(&amp;value, &amp;list[value]);</code></strong></p>
                        <ul>
                            <li>此時 <code>value</code> 的值是 4。</li>
                            <li>所以 <code>list[value]</code> 指的是 <code>list[4]</code>。</li>
                            <li><code>list[4]</code> 的值是 8。</li>
                            <li>交換 <code>value</code> (目前值為 4) 和 <code>list[4]</code> (值為 8)。</li>
                            <li>之後：<code>value = 8</code>, <code>list[4] = 4</code>。</li>
                            <li><code>list</code> 變為 <code>{0, 2, 6, 1, 4}</code>。</li>
                        </ul>
                        <p>程式執行結束時，變數 <code>value</code> 的值為 8。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q2">下一題</button></div>
                </div>

                <div id="q2" class="quiz-card">
                    <h3>2. 下列哪一種演算法採用重複呼叫自己，直至達到設定條件滿足後才逐層跳脫。</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 搜尋</div>
                        <div class="option" data-option="B">(B) 反覆</div>
                        <div class="option" data-option="C">(C) 遞迴</div>
                        <div class="option" data-option="D">(D) 排序</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：演算法特性</h4>
                        <ul>
                            <li><strong>(A) 搜尋 (Searching):</strong> 搜尋演算法的目的是在資料集合中尋找特定的項目。例如線性搜尋、二元搜尋。它們不一定涉及重複呼叫自己。</li>
                            <li><strong>(B) 反覆 (Iteration):</strong> 反覆通常指使用迴圈 (如 for, while) 來重複執行一段程式碼，直到滿足某個終止條件。這與函式呼叫自己不同。</li>
                            <li><strong>(C) 遞迴 (Recursion):</strong> 遞迴是一種演算法或函式設計技巧，其中函式會直接或間接地呼叫自己。每次呼叫都會處理問題的一個較小部分，直到達到一個或多個「基本情況」(base case) 或設定條件，此時遞迴停止，結果會逐層回傳並組合。這完全符合題目描述的「重複呼叫自己，直至達到設定條件滿足後才逐層跳脫」。</li>
                            <li><strong>(D) 排序 (Sorting):</strong> 排序演算法的目的是將資料集合依照特定的順序排列。例如氣泡排序、快速排序。有些排序演算法 (如快速排序、合併排序) 可以用遞迴方式實現，但「排序」本身是一個目標，而不是描述這種自我呼叫機制的術語。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q3">下一題</button></div>
                </div>

                <div id="q3" class="quiz-card">
                    <h3>3. 程式設計時，區域變數(local variable)是指</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 宣告在某個程式檔中的所有變數</div>
                        <div class="option" data-option="B">(B) 宣告在副程式內的變數</div>
                        <div class="option" data-option="C">(C) 副程式呼叫時，呼叫者傳遞給受呼叫者之變數</div>
                        <div class="option" data-option="D">(D) 副程式呼叫時，受呼叫者回傳給受呼叫者的值</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：變數範圍 (Scope)</h4>
                        <p><strong>區域變數 (Local Variable)</strong> 是在一個特定的程式區塊 (block) 或函式 (副程式) 內部宣告的變數。它的主要特性是：</p>
                        <ul>
                            <li><strong>範圍 (Scope):</strong> 區域變數只能在其被宣告的函式或區塊內部被存取。離開該函式或區塊後，該變數就不再可見或可用。</li>
                            <li><strong>生命週期 (Lifetime):</strong> 區域變數通常在程式執行進入其宣告所在的函式或區塊時被創建 (分配記憶體)，並在執行離開該函式或區塊時被銷毀 (釋放記憶體)。(靜態區域變數除外，但這不是本題的核心)</li>
                        </ul>
                        <p>分析選項：</p>
                        <ul>
                            <li><strong>(A) 宣告在某個程式檔中的所有變數：</strong> 宣告在函式外部、檔案層級的變數通常稱為全域變數 (global variables) 或檔案範圍變數，它們不是區域變數。</li>
                            <li><strong>(B) 宣告在副程式內的變數：</strong> 這完全符合區域變數的定義。它們的作用域和生命週期僅限於該副程式。</li>
                            <li><strong>(C) 副程式呼叫時，呼叫者傳遞給受呼叫者之變數：</strong> 這些是參數 (parameters) 或引數 (arguments)。雖然參數在副程式內部行為類似區域變數，但它們的來源是呼叫者。</li>
                            <li><strong>(D) 副程式呼叫時，受呼叫者回傳給受呼叫者的值：</strong> 這是回傳值 (return value)，不是區域變數。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q4">下一題</button></div>
                </div>

                <div id="q4" class="quiz-card">
                    <h3>4. 在下列程式片段中，其執行之輸出結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
#include &lt;string.h&gt; // Required for strcat and puts (though puts is often in stdio.h)
int main(void) { // Added main function for runnable example
    char s1[10] = "DCBA";
    char s2[] = "E";
    puts(strcat(s1, s2));
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q4-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) EDcBA</div>
                        <div class="option" data-option="B">(B) EABcBcc</div>
                        <div class="option" data-option="C">(C) DcBAE</div>
                        <div class="option" data-option="D">(D) EABcD</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：字串函式 <code>strcat</code> 和 <code>puts</code></h4>
                        <p>分析程式碼：</p>
                        <ol>
                            <li><code>char s1[10] = "DCBA";</code>：宣告一個字元陣列 <code>s1</code>，大小為 10，並初始化為 "DCBA"。
                                <ul><li><code>s1</code> 的內容是 <code>{'D', 'C', 'B', 'A', '\0', ...}</code>。其長度為 4。</li></ul>
                            </li>
                            <li><code>char s2[] = "E";</code>：宣告一個字元陣列 <code>s2</code>，並初始化為 "E"。編譯器會自動分配足夠的大小。
                                <ul><li><code>s2</code> 的內容是 <code>{'E', '\0'}</code>。其長度為 1。</li></ul>
                            </li>
                            <li><code>strcat(s1, s2)</code>：
                                <ul>
                                    <li><code>strcat</code> 函式 (string concatenation) 會將第二個字串 (<code>s2</code>) 的內容附加到第一個字串 (<code>s1</code>) 的末尾。</li>
                                    <li>它會從 <code>s1</code> 的空終止符 <code>\0</code> 開始附加。</li>
                                    <li>執行後，<code>s1</code> 的內容會被修改。</li>
                                    <li><code>s1</code> 原本是 "DCBA"。<code>s2</code> 是 "E"。</li>
                                    <li><code>strcat</code> 後，<code>s1</code> 變為 "DCBAE"。 (<code>s1[4]</code> 原本是 <code>\0</code>，現在變為 'E'，<code>s1[5]</code> 變為 <code>\0</code>)。</li>
                                    <li><code>strcat</code> 會回傳指向修改後的 <code>s1</code> 的指標。</li>
                                </ul>
                            </li>
                            <li><code>puts(...)</code>：
                                <ul>
                                    <li><code>puts</code> 函式會將傳入的字串輸出到標準輸出 (螢幕)，並在最後自動加上一個換行符 <code>\n</code>。</li>
                                    <li>在此情況下，它會印出 <code>strcat</code> 的回傳值，即修改後的 <code>s1</code>，也就是 "DCBAE"。</li>
                                </ul>
                            </li>
                        </ol>
                        <p>因此，輸出的結果是 "DCBAE" 後面跟著一個換行符（但換行符通常在比較選項時不顯式表示）。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q5">下一題</button></div>
                </div>

                <div id="q5" class="quiz-card">
                    <h3>5. 下列何者不是 ANSI C 之標準副程式函數？</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) printf</div>
                        <div class="option" data-option="B">(B) main</div>
                        <div class="option" data-option="C">(C) scanf</div>
                        <div class="option" data-option="D">(D) pow</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：ANSI C 標準函式庫</h4>
                        <p>ANSI C 標準定義了一組標準函式庫，提供了常用的功能，如輸入/輸出、字串處理、數學運算等。這些函式是 C 語言標準的一部分，C 編譯器通常都會提供這些函式庫的實作。</p>
                        <p>分析選項：</p>
                        <ul>
                            <li><strong>(A) <code>printf</code>：</strong> 是一個標準的輸出函式，定義在 <code>&lt;stdio.h&gt;</code> 中，用於格式化輸出到標準輸出。它是 ANSI C 標準函式。</li>
                            <li><strong>(B) <code>main</code>：</strong> <code>main</code> 函式是 C 程式的進入點 (entry point)。每個可執行的 C 程式都必須有一個 <code>main</code> 函式。然而，<code>main</code> 函式是由程式設計師定義的，而不是由 ANSI C 標準函式庫提供的預定義「副程式函數」。它是作業系統或 C 執行環境呼叫的特殊函式。</li>
                            <li><strong>(C) <code>scanf</code>：</strong> 是一個標準的輸入函式，定義在 <code>&lt;stdio.h&gt;</code> 中，用於從標準輸入讀取格式化輸入。它是 ANSI C 標準函式。</li>
                            <li><strong>(D) <code>pow</code>：</strong> 是一個標準的數學函式，定義在 <code>&lt;math.h&gt;</code> 中，用於計算一個數的次方 (power)。例如 <code>pow(x, y)</code> 計算 x<sup>y</sup>。它是 ANSI C 標準函式。</li>
                        </ul>
                        <p>因此，<code>main</code> 函式雖然對 C 程式至關重要，但它是由使用者定義的程式起點，而非標準函式庫提供的副程式。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q6">下一題</button></div>
                </div>

                <div id="q6" class="quiz-card">
                    <h3>6. 假如 a = 7.0， b = 7.0， c = 6.0， 執行 printf( "％.2f"， sqrt( a + b ＊ c ) )，輸出為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
#include &lt;math.h&gt; // Required for sqrt()
int main(void) {
    double a = 7.0, b = 7.0, c = 6.0; // Use double for sqrt arguments
    // Expression: sqrt( a + b * c )
    // sqrt( 7.0 + 7.0 * 6.0 )
    // sqrt( 7.0 + 42.0 )
    // sqrt( 49.0 )
    // 7.0
    printf("%.2f\n", sqrt( a + b * c )); // Note: "％" should be "%"
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q6-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 49</div>
                        <div class="option" data-option="B">(B) 7.00</div>
                        <div class="option" data-option="C">(C) 7</div>
                        <div class="option" data-option="D">(D) 49.00</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：數學運算與格式化輸出</h4>
                        <p>給定值：<code>a = 7.0</code>, <code>b = 7.0</code>, <code>c = 6.0</code>。</p>
                        <p>要執行的程式碼是 <code>printf( "%.2f", sqrt( a + b * c ) );</code> (假設全形 ％ 和 ＊ 分別修正為半形 % 和 *)。</p>
                        <p><strong>1. 計算括號內的表達式 <code>a + b * c</code>：</strong></p>
                        <ul>
                            <li>依照運算子優先順序，先執行乘法 <code>b * c</code>：
                                <code>7.0 * 6.0 = 42.0</code></li>
                            <li>然後執行加法 <code>a + (b * c)</code>：
                                <code>7.0 + 42.0 = 49.0</code></li>
                        </ul>
                        <p><strong>2. 計算 <code>sqrt(...)</code>：</strong></p>
                        <ul>
                            <li><code>sqrt(49.0)</code>：計算 49.0 的平方根。</li>
                            <li><code>sqrt(49.0) = 7.0</code></li>
                        </ul>
                        <p><strong>3. 執行 <code>printf("%.2f", ... )</code>：</strong></p>
                        <ul>
                            <li><code>%.2f</code> 是格式指定符，表示將一個浮點數輸出，並保留小數點後兩位。</li>
                            <li>要輸出的值是 7.0。</li>
                            <li>格式化後，7.0 顯示為 "7.00"。</li>
                        </ul>
                        <p>因此，程式的輸出結果是 "7.00" (後面可能跟著一個換行符，取決於 printf 的具體實現或是否有 <code>\n</code>，但選項中只關注數值部分)。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q7">下一題</button></div>
                </div>

                <div id="q7" class="quiz-card">
                    <h3>7. 如果呼叫下面這個函式 mystery，並傳入參數 4 給 number，請問這個函式的回傳值為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt; // For main function example
int mystery(int number) {
    if (number &lt;= 1)
        return 1;
    else
        return number*mystery(number-1);
}</code></pre>
                    <button class="run-example-btn" data-code-id="q7-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 1</div>
                        <div class="option" data-option="B">(B) 24</div>
                        <div class="option" data-option="C">(C) 0</div>
                        <div class="option" data-option="D">(D) 4</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：遞迴函式追蹤</h4>
                        <p>函式 <code>mystery</code> 是一個遞迴函式。我們來追蹤當呼叫 <code>mystery(4)</code> 時的執行流程：</p>
                        <ol>
                            <li><strong><code>mystery(4)</code></strong>:
                                <ul>
                                    <li><code>number</code> (4) > 1，所以執行 <code>else</code> 分支。</li>
                                    <li>回傳 <code>4 * mystery(3)</code>。</li>
                                </ul>
                            </li>
                            <li><strong><code>mystery(3)</code></strong> (由上一步呼叫):
                                <ul>
                                    <li><code>number</code> (3) > 1，所以執行 <code>else</code> 分支。</li>
                                    <li>回傳 <code>3 * mystery(2)</code>。</li>
                                </ul>
                            </li>
                            <li><strong><code>mystery(2)</code></strong> (由上一步呼叫):
                                <ul>
                                    <li><code>number</code> (2) > 1，所以執行 <code>else</code> 分支。</li>
                                    <li>回傳 <code>2 * mystery(1)</code>。</li>
                                </ul>
                            </li>
                            <li><strong><code>mystery(1)</code></strong> (由上一步呼叫):
                                <ul>
                                    <li><code>number</code> (1) &lt;= 1，所以執行 <code>if</code> 分支。</li>
                                    <li>回傳 1。 (這是基本情況)</li>
                                </ul>
                            </li>
                        </ol>
                        <p>現在，我們將結果逐層回代：</p>
                        <ul>
                            <li><code>mystery(1)</code> 回傳 1。</li>
                            <li><code>mystery(2)</code> 的結果是 <code>2 * mystery(1) = 2 * 1 = 2</code>。</li>
                            <li><code>mystery(3)</code> 的結果是 <code>3 * mystery(2) = 3 * 2 = 6</code>。</li>
                            <li><code>mystery(4)</code> 的結果是 <code>4 * mystery(3) = 4 * 6 = 24</code>。</li>
                        </ul>
                        <p>這個函式實際上是在計算 <code>number</code> 的階乘 (factorial)，但當 <code>number</code> 為 0 或 1 時，它回傳 1 (標準階乘 0! = 1, 1! = 1)。所以 <code>mystery(4)</code> 計算的是 4!。</p>
                        <p>4! = 4 × 3 × 2 × 1 = 24。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q8">下一題</button></div>
                </div>

                <div id="q8" class="quiz-card">
                    <h3>8. 下列何者為傳址呼叫(call by address)的特點？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 以額外記憶體存放副程式的參數</div>
                        <div class="option" data-option="B">(B) 主程式參數值不因副程式改變而變</div>
                        <div class="option" data-option="C">(C) 主程式參數名稱取代副程式相對應形式參數名稱</div>
                        <div class="option" data-option="D">(D) 主副兩程式參數佔用相同記憶體位址</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：參數傳遞機制</h4>
                        <p><strong>傳址呼叫 (Call by Address 或 Call by Reference)</strong> 是一種參數傳遞機制，其中傳遞給副程式的是實際參數的記憶體位址，而不是其值的副本。</p>
                        <p>分析選項：</p>
                        <ul>
                            <li><strong>(A) 以額外記憶體存放副程式的參數：</strong>
                                <ul>
                                    <li>在傳址呼叫中，副程式的參數（形式參數）本身確實會佔用一些記憶體，用來儲存傳遞過來的位址。</li>
                                    <li>然而，這個選項的描述不夠精確，也可能適用於傳值呼叫（值的副本也需要記憶體）。傳址呼叫的關鍵不在於參數本身是否佔用記憶體，而在於它儲存的是什麼。</li>
                                </ul>
                            </li>
                            <li><strong>(B) 主程式參數值不因副程式改變而變：</strong>
                                <ul>
                                    <li>這是<strong>傳值呼叫 (call by value)</strong> 的主要特點。在傳值呼叫中，副程式操作的是實際參數的副本，所以對副本的修改不會影響主程式中的原始參數。</li>
                                    <li>在傳址呼叫中，由於副程式擁有實際參數的位址，它可以透過該位址直接修改主程式中實際參數的值。因此，主程式參數值<strong>可以</strong>因副程式改變而變。</li>
                                </ul>
                            </li>
                            <li><strong>(C) 主程式參數名稱取代副程式相對應形式參數名稱：</strong>
                                <ul>
                                    <li>這描述的是一種宏替換或某些特定語言的名稱綁定機制，不是標準的傳址呼叫。在 C 語言中，形式參數有自己的名稱，與實際參數的名稱無關。</li>
                                </ul>
                            </li>
                            <li><strong>(D) 主副兩程式參數佔用相同記憶體位址：</strong>
                                <ul>
                                    <li>這是對傳址呼叫的正確描述。更準確地說，副程式的形式參數（一個指標）儲存了主程式中實際參數的記憶體位址。因此，當副程式透過解參考 (dereferencing) 這個指標來存取或修改值時，它操作的是主程式中實際參數所在的同一塊記憶體。</li>
                                </ul>
                            </li>
                        </ul>
                        <p>因此，傳址呼叫的核心特點是副程式能夠存取並可能修改主程式變數的原始記憶體位置。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q9">下一題</button></div>
                </div>

                <div id="q9" class="quiz-card">
                    <h3>9. 執行下列 C 程式片段，請問輸出的第 9 個數值是？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
unsigned long int test(unsigned int n){
    unsigned long int result;
    if (n==0) result=1;
    else result=n*test(n-1);
    return result;
}

int main(void){ // Corrected from void main
    unsigned int j,N=15;
    // We need the 9th output value, which corresponds to j=8 (since j starts from 0)
    // So we are interested in test(8)
    printf("Outputs from test(j):\n");
    for(j=0;j&lt;N;++j) {
        // For demonstration, we'll print all, but highlight the 9th
        if (j == 8) {
             printf("--> Output %u (value of test(%u)): %lu\n", j+1, j, test(j));
        } else {
            // printf("    Output %u (value of test(%u)): %lu\n", j+1, j, test(j));
        }
    }
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q9-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 362880</div>
                        <div class="option" data-option="B">(B) 720</div>
                        <div class="option" data-option="C">(C) 40320</div>
                        <div class="option" data-option="D">(D) 5040</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：遞迴階乘與迴圈輸出</h4>
                        <p>函式 <code>test(n)</code> 計算的是 n 的階乘 (n!)，其中 0! 定義為 1。</p>
                        <p><code>main</code> 函式中的迴圈 <code>for(j=0;j&lt;N;++j)</code> 會依序印出 <code>test(0)</code>, <code>test(1)</code>, ..., <code>test(N-1)</code> 的結果。這裡 <code>N=15</code>。</p>
                        <p>題目要求的是「輸出的第 9 個數值」。由於迴圈變數 <code>j</code> 從 0 開始：</p>
                        <ul>
                            <li>第 1 個輸出是 <code>test(0)</code> (當 <code>j=0</code>)</li>
                            <li>第 2 個輸出是 <code>test(1)</code> (當 <code>j=1</code>)</li>
                            <li>...</li>
                            <li>第 9 個輸出是 <code>test(8)</code> (當 <code>j=8</code>)</li>
                        </ul>
                        <p>所以我們需要計算 <code>test(8)</code>，即 8!。</p>
                        <p>8! = 8 × 7 × 6 × 5 × 4 × 3 × 2 × 1</p>
                        <ul>
                            <li>1! = 1</li>
                            <li>2! = 2 × 1 = 2</li>
                            <li>3! = 3 × 2 = 6</li>
                            <li>4! = 4 × 6 = 24</li>
                            <li>5! = 5 × 24 = 120</li>
                            <li>6! = 6 × 120 = 720</li>
                            <li>7! = 7 × 720 = 5040</li>
                            <li>8! = 8 × 5040 = 40320</li>
                        </ul>
                        <p>因此，輸出的第 9 個數值是 40320。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q10">下一題</button></div>
                </div>

                <div id="q10" class="quiz-card">
                    <h3>10. 假如 a=9.0， b=8.0 以及 c=9.0， 請問執行下列程式後，會顯示什麼？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
#include &lt;math.h&gt; // Required for sqrt()
int main(void) {
    double a=9.0, b=8.0, c=9.0;
    // Expression: sqrt(a + b * c)
    // sqrt(9.0 + 8.0 * 9.0)
    // sqrt(9.0 + 72.0)
    // sqrt(81.0)
    // 9.0
    printf("%.2f\n", sqrt(a+b*c));
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q10-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 8.00</div>
                        <div class="option" data-option="B">(B) 9.00</div>
                        <div class="option" data-option="C">(C) 10.00</div>
                        <div class="option" data-option="D">(D) 81.00</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：數學運算與格式化輸出</h4>
                        <p>給定值：<code>a = 9.0</code>, <code>b = 8.0</code>, <code>c = 9.0</code>。</p>
                        <p>要執行的程式碼是 <code>printf("%.2f", sqrt(a+b*c));</code>。</p>
                        <p><strong>1. 計算括號內的表達式 <code>a + b * c</code>：</strong></p>
                        <ul>
                            <li>依照運算子優先順序，先執行乘法 <code>b * c</code>：
                                <code>8.0 * 9.0 = 72.0</code></li>
                            <li>然後執行加法 <code>a + (b * c)</code>：
                                <code>9.0 + 72.0 = 81.0</code></li>
                        </ul>
                        <p><strong>2. 計算 <code>sqrt(...)</code>：</strong></p>
                        <ul>
                            <li><code>sqrt(81.0)</code>：計算 81.0 的平方根。</li>
                            <li><code>sqrt(81.0) = 9.0</code></li>
                        </ul>
                        <p><strong>3. 執行 <code>printf("%.2f", ... )</code>：</strong></p>
                        <ul>
                            <li><code>%.2f</code> 是格式指定符，表示將一個浮點數輸出，並保留小數點後兩位。</li>
                            <li>要輸出的值是 9.0。</li>
                            <li>格式化後，9.0 顯示為 "9.00"。</li>
                        </ul>
                        <p>因此，程式的輸出結果是 "9.00"。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q11">下一題</button></div>
                </div>

                <div id="q11" class="quiz-card">
                    <h3>11. 考慮下列 C 函式，請問以 func(15) 呼叫後回傳值為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt; // For main example
int func(int n){
    if (n&lt;=2)
        return n;
    else
        // Note: Integer division for func(n-1)/2
        return func(n-1)/2 + func(n-2);
}</code></pre>
                    <button class="run-example-btn" data-code-id="q11-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 30</div>
                        <div class="option" data-option="B">(B) 32</div>
                        <div class="option" data-option="C">(C) 34</div>
                        <div class="option" data-option="D">(D) 36</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：遞迴函式追蹤</h4>
                        <p>我們需要追蹤 <code>func(15)</code> 的呼叫。注意 <code>func(n-1)/2</code> 是整數除法。</p>
                        <ul>
                            <li><code>func(0) = 0</code> (基本情況)</li>
                            <li><code>func(1) = 1</code> (基本情況)</li>
                            <li><code>func(2) = 2</code> (基本情況)</li>
                            <li><code>func(3) = func(2)/2 + func(1) = 2/2 + 1 = 1 + 1 = 2</code></li>
                            <li><code>func(4) = func(3)/2 + func(2) = 2/2 + 2 = 1 + 2 = 3</code></li>
                            <li><code>func(5) = func(4)/2 + func(3) = 3/2 + 2 = 1 + 2 = 3</code> (3/2 is 1 due to integer division)</li>
                            <li><code>func(6) = func(5)/2 + func(4) = 3/2 + 3 = 1 + 3 = 4</code></li>
                            <li><code>func(7) = func(6)/2 + func(5) = 4/2 + 3 = 2 + 3 = 5</code></li>
                            <li><code>func(8) = func(7)/2 + func(6) = 5/2 + 4 = 2 + 4 = 6</code></li>
                            <li><code>func(9) = func(8)/2 + func(7) = 6/2 + 5 = 3 + 5 = 8</code></li>
                            <li><code>func(10) = func(9)/2 + func(8) = 8/2 + 6 = 4 + 6 = 10</code></li>
                            <li><code>func(11) = func(10)/2 + func(9) = 10/2 + 8 = 5 + 8 = 13</code></li>
                            <li><code>func(12) = func(11)/2 + func(10) = 13/2 + 10 = 6 + 10 = 16</code></li>
                            <li><code>func(13) = func(12)/2 + func(11) = 16/2 + 13 = 8 + 13 = 21</code></li>
                            <li><code>func(14) = func(13)/2 + func(12) = 21/2 + 16 = 10 + 16 = 26</code></li>
                            <li><code>func(15) = func(14)/2 + func(13) = 26/2 + 21 = 13 + 21 = 34</code></li>
                        </ul>
                        <p>因此，<code>func(15)</code> 的回傳值是 34。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q12">下一題</button></div>
                </div>

                <div id="q12" class="quiz-card">
                    <h3>12. 若一仿 C 程式如下，若輸入 n 值為 3，當程式執行結束結果值為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt; // For main example
// Assuming the function is named X_func to avoid conflict if X is a variable
int X_func(int n){
    if (n&lt;1)
        return 3;
    else
        return 3+X_func(n-1);
}</code></pre>
                    <button class="run-example-btn" data-code-id="q12-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 12</div>
                        <div class="option" data-option="B">(B) 3</div>
                        <div class="option" data-option="C">(C) 6</div>
                        <div class="option" data-option="D">(D) 程式無法停止</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：遞迴函式追蹤</h4>
                        <p>我們追蹤當以 <code>n=3</code> 呼叫函式 <code>X_func(3)</code> (原名 X) 時的執行流程：</p>
                        <ol>
                            <li><strong><code>X_func(3)</code></strong>:
                                <ul>
                                    <li><code>n</code> (3) 不 < 1，所以執行 <code>else</code> 分支。</li>
                                    <li>回傳 <code>3 + X_func(2)</code>。</li>
                                </ul>
                            </li>
                            <li><strong><code>X_func(2)</code></strong> (由上一步呼叫):
                                <ul>
                                    <li><code>n</code> (2) 不 < 1，所以執行 <code>else</code> 分支。</li>
                                    <li>回傳 <code>3 + X_func(1)</code>。</li>
                                </ul>
                            </li>
                            <li><strong><code>X_func(1)</code></strong> (由上一步呼叫):
                                <ul>
                                    <li><code>n</code> (1) 不 < 1，所以執行 <code>else</code> 分支。</li>
                                    <li>回傳 <code>3 + X_func(0)</code>。</li>
                                </ul>
                            </li>
                            <li><strong><code>X_func(0)</code></strong> (由上一步呼叫):
                                <ul>
                                    <li><code>n</code> (0) < 1，所以執行 <code>if</code> 分支。</li>
                                    <li>回傳 3。 (基本情況)</li>
                                </ul>
                            </li>
                        </ol>
                        <p>現在，我們將結果逐層回代：</p>
                        <ul>
                            <li><code>X_func(0)</code> 回傳 3。</li>
                            <li><code>X_func(1)</code> 的結果是 <code>3 + X_func(0) = 3 + 3 = 6</code>。</li>
                            <li><code>X_func(2)</code> 的結果是 <code>3 + X_func(1) = 3 + 6 = 9</code>。</li>
                            <li><code>X_func(3)</code> 的結果是 <code>3 + X_func(2) = 3 + 9 = 12</code>。</li>
                        </ul>
                        <p>因此，當輸入 n 值為 3，程式執行結束結果值為 12。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q13">下一題</button></div>
                </div>

                <div id="q13" class="quiz-card">
                    <h3>13. 針對以下 C++程式，f(8,3)輸出是哪一個值？ (註：此程式碼在C中也有效)</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt; // For main example
int f(int x, int y){
    if (x==y)
        return 0;
    else
        return f(x-1, y)+1;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q13-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 3</div>
                        <div class="option" data-option="B">(B) 5</div>
                        <div class="option" data-option="C">(C) 8</div>
                        <div class="option" data-option="D">(D) 11</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：遞迴函式追蹤</h4>
                        <p>我們追蹤呼叫 <code>f(8, 3)</code> 時的執行流程：</p>
                        <ol>
                            <li><strong><code>f(8, 3)</code></strong>: <code>x</code>(8) != <code>y</code>(3). 回傳 <code>f(7, 3) + 1</code>.</li>
                            <li><strong><code>f(7, 3)</code></strong>: <code>x</code>(7) != <code>y</code>(3). 回傳 <code>f(6, 3) + 1</code>.</li>
                            <li><strong><code>f(6, 3)</code></strong>: <code>x</code>(6) != <code>y</code>(3). 回傳 <code>f(5, 3) + 1</code>.</li>
                            <li><strong><code>f(5, 3)</code></strong>: <code>x</code>(5) != <code>y</code>(3). 回傳 <code>f(4, 3) + 1</code>.</li>
                            <li><strong><code>f(4, 3)</code></strong>: <code>x</code>(4) != <code>y</code>(3). 回傳 <code>f(3, 3) + 1</code>.</li>
                            <li><strong><code>f(3, 3)</code></strong>: <code>x</code>(3) == <code>y</code>(3). 回傳 0. (基本情況)</li>
                        </ol>
                        <p>現在，將結果逐層回代：</p>
                        <ul>
                            <li><code>f(3, 3)</code> 回傳 0.</li>
                            <li><code>f(4, 3)</code> 回傳 <code>f(3, 3) + 1 = 0 + 1 = 1</code>.</li>
                            <li><code>f(5, 3)</code> 回傳 <code>f(4, 3) + 1 = 1 + 1 = 2</code>.</li>
                            <li><code>f(6, 3)</code> 回傳 <code>f(5, 3) + 1 = 2 + 1 = 3</code>.</li>
                            <li><code>f(7, 3)</code> 回傳 <code>f(6, 3) + 1 = 3 + 1 = 4</code>.</li>
                            <li><code>f(8, 3)</code> 回傳 <code>f(7, 3) + 1 = 4 + 1 = 5</code>.</li>
                        </ul>
                        <p>這個函式計算的是 <code>x - y</code> 的值 (前提是 <code>x >= y</code>)。當 <code>x=8, y=3</code>，結果是 <code>8 - 3 = 5</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q14">下一題</button></div>
                </div>

                <div id="q14" class="quiz-card">
                    <h3>14. 呼叫下列的函式，fibonacci(2)答案為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt; // For main example
int fibonacci(int n) {
    if (n==0||n==1)
        return n;
    else
        return fibonacci(n-1) + fibonacci(n-2);
}</code></pre>
                    <button class="run-example-btn" data-code-id="q14-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 1</div>
                        <div class="option" data-option="B">(B) 2</div>
                        <div class="option" data-option="C">(C) 3</div>
                        <div class="option" data-option="D">(D) 4</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：費氏數列遞迴</h4>
                        <p>費氏數列的定義通常是 F(0)=0, F(1)=1, 且對於 n > 1, F(n) = F(n-1) + F(n-2)。</p>
                        <p>我們追蹤 <code>fibonacci(2)</code> 的呼叫：</p>
                        <ol>
                            <li><strong><code>fibonacci(2)</code></strong>:
                                <ul>
                                    <li><code>n</code> (2) 不等於 0 或 1，執行 <code>else</code> 分支。</li>
                                    <li>回傳 <code>fibonacci(1) + fibonacci(0)</code>。</li>
                                </ul>
                            </li>
                            <li><strong><code>fibonacci(1)</code></strong> (由上一步呼叫):
                                <ul>
                                    <li><code>n</code> (1) 等於 1，執行 <code>if</code> 分支。</li>
                                    <li>回傳 1。 (基本情況)</li>
                                </ul>
                            </li>
                            <li><strong><code>fibonacci(0)</code></strong> (由第一步呼叫):
                                <ul>
                                    <li><code>n</code> (0) 等於 0，執行 <code>if</code> 分支。</li>
                                    <li>回傳 0。 (基本情況)</li>
                                </ul>
                            </li>
                        </ol>
                        <p>將結果回代：</p>
                        <p><code>fibonacci(2) = fibonacci(1) + fibonacci(0) = 1 + 0 = 1</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q15">下一題</button></div>
                </div>

                <div id="q15" class="quiz-card">
                    <h3>15. 呼叫下列的函式，fibonacci(6)答案為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt; // For main example
int fibonacci(int n) {
    if (n==0||n==1)
        return n;
    else
        return fibonacci(n-1) + fibonacci(n-2);
}</code></pre>
                    <button class="run-example-btn" data-code-id="q15-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 3</div>
                        <div class="option" data-option="B">(B) 5</div>
                        <div class="option" data-option="C">(C) 8</div>
                        <div class="option" data-option="D">(D) 13</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：費氏數列遞迴</h4>
                        <p>我們計算費氏數列的序列：</p>
                        <ul>
                            <li><code>fibonacci(0) = 0</code></li>
                            <li><code>fibonacci(1) = 1</code></li>
                            <li><code>fibonacci(2) = fibonacci(1) + fibonacci(0) = 1 + 0 = 1</code></li>
                            <li><code>fibonacci(3) = fibonacci(2) + fibonacci(1) = 1 + 1 = 2</code></li>
                            <li><code>fibonacci(4) = fibonacci(3) + fibonacci(2) = 2 + 1 = 3</code></li>
                            <li><code>fibonacci(5) = fibonacci(4) + fibonacci(3) = 3 + 2 = 5</code></li>
                            <li><code>fibonacci(6) = fibonacci(5) + fibonacci(4) = 5 + 3 = 8</code></li>
                        </ul>
                        <p>遞迴呼叫樹狀圖 (部分)：</p>
                        <pre>
        fibonacci(6)
       /            \
  fibonacci(5)   +   fibonacci(4)
 /      \          /      \
fib(4) + fib(3)  fib(3) + fib(2)
... 等等 ...
</pre>
                        <p>最終，<code>fibonacci(6)</code> 的結果是 8。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q16">下一題</button></div>
                </div>

                <div id="q16" class="quiz-card">
                    <h3>16. 給予一個整數陣列 int n[10]={3,5,7,9,11,14,17,33,44,50}， 呼叫下圖的函式 bsearch(n, 44, 0, 9) 來搜尋 44，請問 while 迴圈內的指令 middle = (low+high)/2 會被執行幾次？</h3>
                    <pre><code class="language-c">// Function provided in question image
// int bsearch(int b[], int Key, int low, int high){
//     int middle;
//     while (low &lt;= high){
//         printf("%d", 1); // This line helps count loop iterations
//         middle=(low+high)/2; // This is the target instruction
//         if (Key == b[middle])
//             return middle;
//         else if (Key &lt; b[middle])
//             high = middle -1;
//         else
//             low = middle+1;
//     }
//     return -1;
// }
</code></pre>
                    <button class="run-example-btn" data-code-id="q16-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 2</div>
                        <div class="option" data-option="B">(B) 3</div>
                        <div class="option" data-option="C">(C) 4</div>
                        <div class="option" data-option="D">(D) 5</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：二元搜尋追蹤</h4>
                        <p>陣列 <code>n = {3, 5, 7, 9, 11, 14, 17, 33, 44, 50}</code> (索引 0-9)。
                        我們要搜尋 <code>Key = 44</code>，初始 <code>low = 0</code>, <code>high = 9</code>。</p>
                        <p>追蹤 <code>while</code> 迴圈中 <code>middle = (low+high)/2</code> 的執行次數：</p>
                        <table>
                            <thead><tr><th>迭代</th><th>low</th><th>high</th><th>(low+high)</th><th>middle=(low+high)/2</th><th>n[middle]</th><th>比較 (Key vs n[middle])</th><th>動作</th><th>Executions</th></tr></thead>
                            <tbody>
                                <tr><td>-</td><td>0</td><td>9</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>0</td></tr>
                                <tr><td>1</td><td>0</td><td>9</td><td>9</td><td>4</td><td>n[4]=11</td><td>44 > 11</td><td>low = middle+1 = 5</td><td>1</td></tr>
                                <tr><td>2</td><td>5</td><td>9</td><td>14</td><td>7</td><td>n[7]=33</td><td>44 > 33</td><td>low = middle+1 = 8</td><td>2</td></tr>
                                <tr><td>3</td><td>8</td><td>9</td><td>17</td><td>8</td><td>n[8]=44</td><td>44 == 44</td><td>Key found, return middle (8)</td><td>3</td></tr>
                            </tbody>
                        </table>
                        <p>在第 3 次計算 <code>middle</code> 後，找到了鍵值 44。因此，指令 <code>middle = (low+high)/2</code> 被執行了 3 次。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q17">下一題</button></div>
                </div>

                <div id="q17" class="quiz-card">
                    <h3>17. 同上題 (Q16 的陣列與函式)，呼叫函式 bsearch(n, 13, 0, 9) 來搜尋 key 13，請問 while 迴圈內的指令 middle = (low+high)/2 會被執行幾次？</h3>
                    <pre><code class="language-c">// Function is the same as in Q16
// Array n[10]={3,5,7,9,11,14,17,33,44,50}
</code></pre>
                    <button class="run-example-btn" data-code-id="q17-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 2</div>
                        <div class="option" data-option="B">(B) 3</div>
                        <div class="option" data-option="C">(C) 4</div>
                        <div class="option" data-option="D">(D) 5</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：二元搜尋追蹤</h4>
                        <p>陣列 <code>n = {3, 5, 7, 9, 11, 14, 17, 33, 44, 50}</code>。
                        我們要搜尋 <code>Key = 13</code>，初始 <code>low = 0</code>, <code>high = 9</code>。</p>
                        <p>追蹤 <code>middle = (low+high)/2</code> 的執行次數：</p>
                        <table>
                            <thead><tr><th>迭代</th><th>low</th><th>high</th><th>(low+high)</th><th>middle=(low+high)/2</th><th>n[middle]</th><th>比較 (Key vs n[middle])</th><th>動作</th><th>Executions</th></tr></thead>
                            <tbody>
                                <tr><td>-</td><td>0</td><td>9</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>0</td></tr>
                                <tr><td>1</td><td>0</td><td>9</td><td>9</td><td>4</td><td>n[4]=11</td><td>13 > 11</td><td>low = middle+1 = 5</td><td>1</td></tr>
                                <tr><td>2</td><td>5</td><td>9</td><td>14</td><td>7</td><td>n[7]=33</td><td>13 < 33</td><td>high = middle-1 = 6</td><td>2</td></tr>
                                <tr><td>3</td><td>5</td><td>6</td><td>11</td><td>5</td><td>n[5]=14</td><td>13 < 14</td><td>high = middle-1 = 4</td><td>3</td></tr>
                            </tbody>
                        </table>
                        <p>此時 <code>low = 5</code>, <code>high = 4</code>。因為 <code>low &lt;= high</code> (5 <= 4) 為 false，<code>while</code> 迴圈終止。Key 13 未找到，函式會回傳 -1。</p>
                        <p>指令 <code>middle = (low+high)/2</code> 被執行了 3 次。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q18">下一題</button></div>
                </div>

                <div id="q18" class="quiz-card">
                    <h3>18. 同上題 (Q16 的陣列與函式)，呼叫函式 bsearch(n, 55, 0, 9) 來搜尋 key 55，請問 while 迴圈內的指令 middle = (low+high)/2 會被執行幾次？</h3>
                    <pre><code class="language-c">// Function is the same as in Q16
// Array n[10]={3,5,7,9,11,14,17,33,44,50}
</code></pre>
                    <button class="run-example-btn" data-code-id="q18-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 2</div>
                        <div class="option" data-option="B">(B) 3</div>
                        <div class="option" data-option="C">(C) 4</div>
                        <div class="option" data-option="D">(D) 5</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：二元搜尋追蹤</h4>
                        <p>陣列 <code>n = {3, 5, 7, 9, 11, 14, 17, 33, 44, 50}</code>。
                        我們要搜尋 <code>Key = 55</code>，初始 <code>low = 0</code>, <code>high = 9</code>。</p>
                        <p>追蹤 <code>middle = (low+high)/2</code> 的執行次數：</p>
                        <table>
                            <thead><tr><th>迭代</th><th>low</th><th>high</th><th>(low+high)</th><th>middle=(low+high)/2</th><th>n[middle]</th><th>比較 (Key vs n[middle])</th><th>動作</th><th>Executions</th></tr></thead>
                            <tbody>
                                <tr><td>-</td><td>0</td><td>9</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>0</td></tr>
                                <tr><td>1</td><td>0</td><td>9</td><td>9</td><td>4</td><td>n[4]=11</td><td>55 > 11</td><td>low = middle+1 = 5</td><td>1</td></tr>
                                <tr><td>2</td><td>5</td><td>9</td><td>14</td><td>7</td><td>n[7]=33</td><td>55 > 33</td><td>low = middle+1 = 8</td><td>2</td></tr>
                                <tr><td>3</td><td>8</td><td>9</td><td>17</td><td>8</td><td>n[8]=44</td><td>55 > 44</td><td>low = middle+1 = 9</td><td>3</td></tr>
                                <tr><td>4</td><td>9</td><td>9</td><td>18</td><td>9</td><td>n[9]=50</td><td>55 > 50</td><td>low = middle+1 = 10</td><td>4</td></tr>
                            </tbody>
                        </table>
                        <p>此時 <code>low = 10</code>, <code>high = 9</code>。因為 <code>low &lt;= high</code> (10 <= 9) 為 false，<code>while</code> 迴圈終止。Key 55 未找到，函式會回傳 -1。</p>
                        <p>指令 <code>middle = (low+high)/2</code> 被執行了 4 次。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q19">下一題</button></div>
                </div>

                <div id="q19" class="quiz-card">
                    <h3>19. 執行下列 C 程式後，請問最後 z 輸出是？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int abc(int x, int y){
    int tmp;
    while (x%y != 0){
        tmp=y;
        y=x%y;
        x=tmp;
    }
    return y;
}
int main(void){ // Corrected main
    int z=abc(159, 52);
    printf("%d\n", z); // Corrected format specifier %i to %d
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q19-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 1</div>
                        <div class="option" data-option="B">(B) 2</div>
                        <div class="option" data-option="C">(C) 13</div>
                        <div class="option" data-option="D">(D) 26</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：歐幾里得演算法 (輾轉相除法)</h4>
                        <p>函式 <code>abc(x, y)</code> 實作了歐幾里得演算法來計算兩個正整數 <code>x</code> 和 <code>y</code> 的最大公因數 (GCD)。</p>
                        <p>我們追蹤呼叫 <code>abc(159, 52)</code> 時的執行流程：</p>
                        <table>
                            <thead><tr><th>x</th><th>y</th><th>x % y</th><th>x % y != 0?</th><th>tmp</th><th>新 y (x % y)</th><th>新 x (舊 y)</th></tr></thead>
                            <tbody>
                                <tr><td>159</td><td>52</td><td>159 % 52 = 3</td><td>True (3 != 0)</td><td>52</td><td>3</td><td>52</td></tr>
                                <tr><td>52</td><td>3</td><td>52 % 3 = 1</td><td>True (1 != 0)</td><td>3</td><td>1</td><td>3</td></tr>
                                <tr><td>3</td><td>1</td><td>3 % 1 = 0</td><td>False (0 != 0)</td><td colspan="3">迴圈終止</td></tr>
                            </tbody>
                        </table>
                        <p>當 <code>x % y == 0</code> 時，迴圈終止，函式回傳當時 <code>y</code> 的值。</p>
                        <p>在最後一次判斷前，<code>y</code> 的值是 1。</p>
                        <p>因此，<code>abc(159, 52)</code> 回傳 1。變數 <code>z</code> 被賦值為 1，所以程式輸出 1。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q20">下一題</button></div>
                </div>

                <div id="q20" class="quiz-card">
                    <h3>20. 執行下列 C 程式後，請問最後 z 輸出是？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int def(int x){
    if (x==1) return 1;
    else {
        int i, B=0, A=1, O=0, S=0; // Initialize O
        // Loop for i from 2 to x
        for (i=2;i&lt;=x;i++){
            S=A+B;
            O=S; // O stores the current Fibonacci number
            B=A;
            A=S;
        }
        return O; // Returns the x-th Fibonacci number (if F(1)=1, F(2)=1)
    }
}
int main(void){ // Corrected main
    int z=def(7);
    printf("%d\n", z); // Corrected format specifier %i to %d
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q20-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 5</div>
                        <div class="option" data-option="B">(B) 8</div>
                        <div class="option" data-option="C">(C) 13</div>
                        <div class="option" data-option="D">(D) 21</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：迭代計算費氏數列</h4>
                        <p>函式 <code>def(x)</code> 計算的是一個類似費氏數列的序列。
                        如果 <code>x=1</code>，回傳 1。</p>
                        <p>如果 <code>x > 1</code>，它使用迭代方式計算。變數 <code>A</code> 和 <code>B</code> 用來保存前兩個數，<code>S</code> 是它們的和，<code>O</code> 用來保存最後計算出的 <code>S</code>。
                        初始時，<code>B=0</code>, <code>A=1</code> (可以看作 F(0) 和 F(1) 的基礎，但函式對應的序列是從 F(1) 開始)。</p>
                        <p>我們追蹤呼叫 <code>def(7)</code> 時的執行流程 (迴圈從 <code>i=2</code> 到 <code>i=7</code>)：</p>
                        <table>
                            <thead><tr><th>i</th><th>B (舊)</th><th>A (舊)</th><th>S = A+B</th><th>O = S</th><th>B (新) = A(舊)</th><th>A (新) = S</th><th>對應費氏數 F(i)</th></tr></thead>
                            <tbody>
                                <tr><td>-</td><td>0 (初始)</td><td>1 (初始)</td><td>-</td><td>0 (初始)</td><td>-</td><td>-</td><td>-</td></tr>
                                <tr><td>2</td><td>0</td><td>1</td><td>1+0=1</td><td>1</td><td>1</td><td>1</td><td>F(2)=1</td></tr>
                                <tr><td>3</td><td>1</td><td>1</td><td>1+1=2</td><td>2</td><td>1</td><td>2</td><td>F(3)=2</td></tr>
                                <tr><td>4</td><td>1</td><td>2</td><td>2+1=3</td><td>3</td><td>2</td><td>3</td><td>F(4)=3</td></tr>
                                <tr><td>5</td><td>2</td><td>3</td><td>3+2=5</td><td>5</td><td>3</td><td>5</td><td>F(5)=5</td></tr>
                                <tr><td>6</td><td>3</td><td>5</td><td>5+3=8</td><td>8</td><td>5</td><td>8</td><td>F(6)=8</td></tr>
                                <tr><td>7</td><td>5</td><td>8</td><td>8+5=13</td><td>13</td><td>8</td><td>13</td><td>F(7)=13</td></tr>
                            </tbody>
                        </table>
                        <p>迴圈結束後，<code>O</code> 的值是 13。函式回傳 <code>O</code>。</p>
                        <p>所以，<code>def(7)</code> 回傳 13。變數 <code>z</code> 被賦值為 13，程式輸出 13。</p>
                        <p>這個函式計算的是第 x 個費氏數 (若定義 F(1)=1, F(2)=1, F(3)=2, ...)。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q21">下一題</button></div>
                </div>

                <div id="q21" class="quiz-card">
                    <h3>21. 下列何者為 C 語言函式，傳回字串長度？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) strcpy</div>
                        <div class="option" data-option="B">(B) lencat</div>
                        <div class="option" data-option="C">(C) strlen</div>
                        <div class="option" data-option="D">(D) strcmp</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：標準字串函式庫</h4>
                        <p>C 語言在 <code>&lt;string.h&gt;</code> 標頭檔中提供了一系列處理字串的標準函式。</p>
                        <ul>
                            <li><strong>(A) <code>strcpy</code> (String Copy):</strong> 用於複製一個字串到另一個字串。原型通常是 <code>char *strcpy(char *dest, const char *src);</code>。它不傳回字串長度。</li>
                            <li><strong>(B) <code>lencat</code>：</strong> 這不是一個標準的 C 語言字串函式。可能是 <code>strcat</code> (string concatenation，字串串接) 或 <code>strlen</code> (string length，字串長度) 的混淆。</li>
                            <li><strong>(C) <code>strlen</code> (String Length):</strong> 用於計算一個字串的長度，長度不包含結尾的空終止符 <code>\0</code>。原型通常是 <code>size_t strlen(const char *str);</code> (<code>size_t</code> 是一種無符號整數型態)。這正是題目所描述的功能。</li>
                            <li><strong>(D) <code>strcmp</code> (String Compare):</strong> 用於比較兩個字串。它會回傳一個整數值，表示兩個字串的字典順序關係 (小於0、等於0 或 大於0)。原型通常是 <code>int strcmp(const char *str1, const char *str2);</code>。它不傳回字串長度。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q22">下一題</button></div>
                </div>

                <div id="q22" class="quiz-card">
                    <h3>22. 以下為 C 語言之主程式呼叫副程式，請呈現 printf 敘述所顯示 x y z 的結果？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt; // Added for printf
// Forward declaration if SubProgram is defined after main, or define before.
void SubProgram(int x_val, int *y_ptr, int *z_ptr);

int main(void){ // Corrected main
    int x=12,y=8,z=4;
    // printf("In main (before): x=%d, y=%d, z=%d\n", x, y, z);
    SubProgram(x, &amp;y, &amp;z);
    printf("x=%d, y=%d, z=%d\n", x, y, z);
    return 0;
}

void SubProgram(int x_val, int *y_ptr, int *z_ptr){
    // x_val is a local copy of main's x
    // *y_ptr refers to main's y
    // *z_ptr refers to main's z
    // printf("In SubProgram (start): x_val=%d, *y_ptr=%d, *z_ptr=%d\n", x_val, *y_ptr, *z_ptr);

    x_val = x_val + *y_ptr - *z_ptr; // x_val = 12 + 8 - 4 = 16. main's x is unchanged.
    // printf("In SubProgram (mid1): x_val=%d, *y_ptr=%d, *z_ptr=%d\n", x_val, *y_ptr, *z_ptr);

    *y_ptr = x_val - *z_ptr - 1;   // *y_ptr = 16 - 4 - 1 = 11. main's y becomes 11.
    // printf("In SubProgram (mid2): x_val=%d, *y_ptr=%d, *z_ptr=%d\n", x_val, *y_ptr, *z_ptr);

    *z_ptr = x_val - *y_ptr;       // *z_ptr = 16 - 11 = 5. main's z becomes 5.
    // printf("In SubProgram (end): x_val=%d, *y_ptr=%d, *z_ptr=%d\n", x_val, *y_ptr, *z_ptr);
}</code></pre>
                    <button class="run-example-btn" data-code-id="q22-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) x=12 y=8 z=4</div>
                        <div class="option" data-option="B">(B) x=16 y=11 z=5</div>
                        <div class="option" data-option="C">(C) x=12 y=11 z=5</div>
                        <div class="option" data-option="D">(D) x=16 y=11 z=4</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：傳值呼叫與傳址呼叫</h4>
                        <p><strong>1. 初始狀態 (在 <code>main</code> 中)：</strong></p>
                        <ul>
                            <li><code>x = 12</code></li>
                            <li><code>y = 8</code></li>
                            <li><code>z = 4</code></li>
                        </ul>
                        <p><strong>2. 呼叫 <code>SubProgram(x, &amp;y, &amp;z)</code>：</strong></p>
                        <ul>
                            <li>參數 <code>x</code> 是以「傳值呼叫」(call by value) 方式傳遞。<code>SubProgram</code> 中的 <code>x_val</code> 會得到 <code>main</code> 中 <code>x</code> 的一個副本。所以 <code>x_val = 12</code>。對 <code>x_val</code> 的修改不會影響 <code>main</code> 中的 <code>x</code>。</li>
                            <li>參數 <code>&amp;y</code> 和 <code>&amp;z</code> 是以「傳址呼叫」(call by address) 方式傳遞。<code>SubProgram</code> 中的指標 <code>y_ptr</code> 會儲存 <code>main</code> 中 <code>y</code> 的記憶體位址，而 <code>z_ptr</code> 會儲存 <code>main</code> 中 <code>z</code> 的記憶體位址。透過 <code>*y_ptr</code> 和 <code>*z_ptr</code> 可以直接修改 <code>main</code> 中的 <code>y</code> 和 <code>z</code>。</li>
                        </ul>
                        <p><strong>3. 執行 <code>SubProgram</code> 內部：</strong></p>
                        <ul>
                            <li>初始時在 <code>SubProgram</code> 內：<code>x_val = 12</code>, <code>*y_ptr = 8</code>, <code>*z_ptr = 4</code>.</li>
                            <li><code>x_val = x_val + *y_ptr - *z_ptr;</code>
                                <ul><li><code>x_val = 12 + 8 - 4 = 16</code>.</li></ul>
                                (此時 <code>main</code> 中的 <code>x</code> 仍為 12. <code>SubProgram</code> 中的 <code>x_val</code> 為 16.)
                            </li>
                            <li><code>*y_ptr = x_val - *z_ptr - 1;</code>
                                <ul><li><code>*y_ptr = 16 - 4 - 1 = 11</code>.</li></ul>
                                (<code>main</code> 中的 <code>y</code> 被修改為 11.)
                            </li>
                            <li><code>*z_ptr = x_val - *y_ptr;</code>
                                <ul><li><code>*z_ptr = 16 - 11 = 5</code>.</li></ul>
                                (<code>main</code> 中的 <code>z</code> 被修改為 5.)
                            </li>
                        </ul>
                        <p><strong>4. 回到 <code>main</code> 函式，執行 <code>printf</code>：</strong></p>
                        <ul>
                            <li><code>main</code> 中的 <code>x</code> 未被 <code>SubProgram</code> 修改，仍為 12。</li>
                            <li><code>main</code> 中的 <code>y</code> 被 <code>SubProgram</code> 修改為 11。</li>
                            <li><code>main</code> 中的 <code>z</code> 被 <code>SubProgram</code> 修改為 5。</li>
                        </ul>
                        <p>所以，輸出的結果是 x=12, y=11, z=5。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q23">下一題</button></div>
                </div>

                <div id="q23" class="quiz-card">
                    <h3>23. 執行下列程式碼後，請問輸出結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int test(int a){
    if (a&lt;=1) return 1; // Factorial of 0 or 1 is 1
    else return a*test(a-1);
}
int main(void){ // Corrected main
    int x_val=5, y_val=2; // Renamed to avoid conflict
    // test(5) = 5! = 120
    // test(2) = 2! = 2
    // test(x_val-y_val) = test(5-2) = test(3) = 3! = 6
    // z_val = 120 / 2 * 6 = 60 * 6 = 360
    int z_val=test(x_val)/test(y_val)*test(x_val-y_val); // Renamed
    printf("%d\n", z_val);
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q23-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 24</div>
                        <div class="option" data-option="B">(B) 180</div>
                        <div class="option" data-option="C">(C) 360</div>
                        <div class="option" data-option="D">(D) 720</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：遞迴階乘函式呼叫</h4>
                        <p>函式 <code>test(a)</code> 計算的是 <code>a</code> 的階乘 (a!)，並且定義 0! = 1 和 1! = 1。</p>
                        <p>在 <code>main</code> 函式中：</p>
                        <ul>
                            <li><code>x_val = 5</code></li>
                            <li><code>y_val = 2</code></li>
                        </ul>
                        <p>我們要計算 <code>z_val = test(x_val) / test(y_val) * test(x_val - y_val)</code>。</p>
                        <p><strong>1. 計算 <code>test(x_val)</code> 即 <code>test(5)</code>：</strong></p>
                        <p><code>test(5) = 5! = 5 × 4 × 3 × 2 × 1 = 120</code>。</p>
                        <p><strong>2. 計算 <code>test(y_val)</code> 即 <code>test(2)</code>：</strong></p>
                        <p><code>test(2) = 2! = 2 × 1 = 2</code>。</p>
                        <p><strong>3. 計算 <code>test(x_val - y_val)</code> 即 <code>test(5 - 2) = test(3)</code>：</strong></p>
                        <p><code>test(3) = 3! = 3 × 2 × 1 = 6</code>。</p>
                        <p><strong>4. 計算 <code>z_val</code>：</strong></p>
                        <p><code>z_val = test(5) / test(2) * test(3)</code></p>
                        <p><code>z_val = 120 / 2 * 6</code></p>
                        <p>根據運算子優先順序，除法和乘法具有相同的優先級，通常從左到右計算：</p>
                        <p><code>z_val = (120 / 2) * 6 = 60 * 6 = 360</code>。</p>
                        <p>因此，程式的輸出結果是 360。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q24">下一題</button></div>
                </div>

                <div id="q24" class="quiz-card">
                    <h3>24. 執行下列程式碼後，請問輸出結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int TestYou(int a){
    if (a==1) return 0;
    else return TestYou(a-1)+a*(a+1);
}
int main(void){ // Corrected main
    int a_val=5;
    int b_val=TestYou(a_val);
    printf("%d\n", b_val); // Corrected format specifier %i to %d
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q24-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 110</div>
                        <div class="option" data-option="B">(B) 68</div>
                        <div class="option" data-option="C">(C) 38</div>
                        <div class="option" data-option="D">(D) 166</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：遞迴函式追蹤</h4>
                        <p>我們追蹤呼叫 <code>TestYou(5)</code> 時的執行流程：</p>
                        <ul>
                            <li><strong><code>TestYou(5)</code></strong>: <code>a</code>(5) != 1. 回傳 <code>TestYou(4) + 5*(5+1)</code> = <code>TestYou(4) + 5*6</code> = <code>TestYou(4) + 30</code>.</li>
                            <li><strong><code>TestYou(4)</code></strong>: <code>a</code>(4) != 1. 回傳 <code>TestYou(3) + 4*(4+1)</code> = <code>TestYou(3) + 4*5</code> = <code>TestYou(3) + 20</code>.</li>
                            <li><strong><code>TestYou(3)</code></strong>: <code>a</code>(3) != 1. 回傳 <code>TestYou(2) + 3*(3+1)</code> = <code>TestYou(2) + 3*4</code> = <code>TestYou(2) + 12</code>.</li>
                            <li><strong><code>TestYou(2)</code></strong>: <code>a</code>(2) != 1. 回傳 <code>TestYou(1) + 2*(2+1)</code> = <code>TestYou(1) + 2*3</code> = <code>TestYou(1) + 6</code>.</li>
                            <li><strong><code>TestYou(1)</code></strong>: <code>a</code>(1) == 1. 回傳 0. (基本情況)</li>
                        </ul>
                        <p>現在，將結果逐層回代：</p>
                        <ul>
                            <li><code>TestYou(1)</code> = 0.</li>
                            <li><code>TestYou(2)</code> = <code>TestYou(1) + 6 = 0 + 6 = 6</code>.</li>
                            <li><code>TestYou(3)</code> = <code>TestYou(2) + 12 = 6 + 12 = 18</code>.</li>
                            <li><code>TestYou(4)</code> = <code>TestYou(3) + 20 = 18 + 20 = 38</code>.</li>
                            <li><code>TestYou(5)</code> = <code>TestYou(4) + 30 = 38 + 30 = 68</code>.</li>
                        </ul>
                        <p>因此，<code>b_val</code> 的值是 68，程式輸出 68。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q25">下一題</button></div>
                </div>

                <div id="q25" class="quiz-card">
                    <h3>25. 執行下列程式碼後，請問輸出結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
// Renamed function to avoid conflict if TestYou is used elsewhere with different signature
int TestYou_gcd(int a, int b){
    if (b==0) return a;
    else return TestYou_gcd(b, a%b);
}
int main(void){ // Corrected main
    int c_val=TestYou_gcd(306, 68); // Renamed variable
    printf("%d\n", c_val); // Corrected format specifier %i to %d
    return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q25-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 153</div>
                        <div class="option" data-option="B">(B) 306</div>
                        <div class="option" data-option="C">(C) 68</div>
                        <div class="option" data-option="D">(D) 34</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：遞迴歐幾里得演算法 (GCD)</h4>
                        <p>函式 <code>TestYou_gcd(a, b)</code> (原名 TestYou) 使用遞迴方式實作歐幾里得演算法來計算兩個數 <code>a</code> 和 <code>b</code> 的最大公因數 (GCD)。</p>
                        <p>我們追蹤呼叫 <code>TestYou_gcd(306, 68)</code> 時的執行流程：</p>
                        <ol>
                            <li><strong><code>TestYou_gcd(306, 68)</code></strong>:
                                <ul>
                                    <li><code>b</code> (68) != 0.</li>
                                    <li><code>a % b = 306 % 68</code>.
                                        <ul>
                                            <li>306 = 4 * 68 + 34. So, <code>306 % 68 = 34</code>.</li>
                                        </ul>
                                    </li>
                                    <li>回傳 <code>TestYou_gcd(68, 34)</code>.</li>
                                </ul>
                            </li>
                            <li><strong><code>TestYou_gcd(68, 34)</code></strong>:
                                <ul>
                                    <li><code>b</code> (34) != 0.</li>
                                    <li><code>a % b = 68 % 34</code>.
                                        <ul>
                                            <li>68 = 2 * 34 + 0. So, <code>68 % 34 = 0</code>.</li>
                                        </ul>
                                    </li>
                                    <li>回傳 <code>TestYou_gcd(34, 0)</code>.</li>
                                </ul>
                            </li>
                            <li><strong><code>TestYou_gcd(34, 0)</code></strong>:
                                <ul>
                                    <li><code>b</code> (0) == 0.</li>
                                    <li>回傳 <code>a</code>，即 34. (基本情況)</li>
                                </ul>
                            </li>
                        </ol>
                        <p>結果逐層回傳：</p>
                        <ul>
                            <li><code>TestYou_gcd(34, 0)</code> 回傳 34.</li>
                            <li><code>TestYou_gcd(68, 34)</code> 回傳 34.</li>
                            <li><code>TestYou_gcd(306, 68)</code> 回傳 34.</li>
                        </ul>
                        <p>因此，<code>c_val</code> 的值是 34，程式輸出 34。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
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
                'q1-code': '#include <stdio.h>\nvoid swap(int *a, int *b){ int t; t=*a;*a=*b;*b=t; }\nint main(void){\n    int value=1, list[5]={0,2,4,6,8};\n    printf("Initial: value=%d, list={%d,%d,%d,%d,%d}\\n", value, list[0],list[1],list[2],list[3],list[4]);\n    swap(&list[2],&list[3]);\n    printf("After swap1: value=%d, list={%d,%d,%d,%d,%d}\\n", value, list[0],list[1],list[2],list[3],list[4]);\n    swap(&value,&list[3]);\n    printf("After swap2: value=%d, list={%d,%d,%d,%d,%d}\\n", value, list[0],list[1],list[2],list[3],list[4]);\n    // Note: list[value] uses the current value of \'value\' as the index.\n    // If value became 4, list[value] is list[4].\n    swap(&value,&list[list[value]]);\n    printf("After swap3: value=%d, list={%d,%d,%d,%d,%d}\\n", value, list[0],list[1],list[2],list[3],list[4]);\n    printf("Final value: %d\\n", value);\n    return 0;\n}',
                'q4-code': '#include <stdio.h>\n#include <string.h>\nint main(void) {\n    char s1[10] = "DCBA";\n    char s2[] = "E";\n    puts(strcat(s1, s2));\n    return 0;\n}',
                'q6-code': '#include <stdio.h>\n#include <math.h>\nint main(void) {\n    double a = 7.0, b = 7.0, c = 6.0;\n    printf("%.2f\\n", sqrt( a + b * c ));\n    return 0;\n}',
                'q7-code': '#include <stdio.h>\nint mystery(int number) {\n    if (number <= 1) return 1;\n    else return number*mystery(number-1);\n}\nint main(void) {\n    printf("%d\\n", mystery(4));\n    return 0;\n}',
                'q9-code': '#include <stdio.h>\nunsigned long int test(unsigned int n){\n    unsigned long int result;\n    if (n==0) result=1;\n    else result=n*test(n-1);\n    return result;\n}\nint main(void){\n    unsigned int j,N=15;\n    printf("Outputs from test(j):\\n");\n    for(j=0;j<N;++j) {\n        if (j == 8) {\n             printf("--> Output %u (test(%u)): %lu\\n", j+1, j, test(j));\n        } else if (j < 3 || j > N-4) { // Print a few at start/end for context\n             printf("    Output %u (test(%u)): %lu\\n", j+1, j, test(j));\n        } else if (j == 3) {\n             printf("    ... (intermediate values omitted) ...\\n");\n        }\n    }\n    return 0;\n}',
                'q10-code': '#include <stdio.h>\n#include <math.h>\nint main(void) {\n    double a=9.0, b=8.0, c=9.0;\n    printf("%.2f\\n", sqrt(a+b*c));\n    return 0;\n}',
                'q11-code': '#include <stdio.h>\nint func(int n){\n    if (n<=2) return n;\n    else return func(n-1)/2 + func(n-2);\n}\nint main(void) {\n    printf("func(3)=%d\\n", func(3));\n    printf("func(4)=%d\\n", func(4));\n    printf("func(5)=%d\\n", func(5));\n    printf("func(15)=%d\\n", func(15));\n    return 0;\n}',
                'q12-code': '#include <stdio.h>\nint X_func(int n){\n    if (n<1) return 3;\n    else return 3+X_func(n-1);\n}\nint main(void) {\n    printf("%d\\n", X_func(3));\n    return 0;\n}',
                'q13-code': '#include <stdio.h>\nint f(int x, int y){\n    if (x==y) return 0;\n    else return f(x-1, y)+1;\n}\nint main(void) {\n    printf("%d\\n", f(8,3));\n    return 0;\n}',
                'q14-code': '#include <stdio.h>\nint fibonacci(int n) {\n    if (n==0||n==1) return n;\n    else return fibonacci(n-1) + fibonacci(n-2);\n}\nint main(void) {\n    printf("fibonacci(2) = %d\\n", fibonacci(2));\n    return 0;\n}',
                'q15-code': '#include <stdio.h>\nint fibonacci(int n) {\n    if (n==0||n==1) return n;\n    else return fibonacci(n-1) + fibonacci(n-2);\n}\nint main(void) {\n    printf("fibonacci(6) = %d\\n", fibonacci(6));\n    return 0;\n}',
                'q16-code': '#include <stdio.h>\nint middle_executions_q16 = 0;\nint bsearch_q16(int b[], int Key, int low, int high){\n    int middle;\n    middle_executions_q16 = 0;\n    while (low <= high){\n        middle_executions_q16++;\n        middle=(low+high)/2;\n        printf("low=%d, high=%d, middle=%d, b[middle]=%d, executions=%d\\n", low, high, middle, b[middle], middle_executions_q16);\n        if (Key == b[middle]) return middle;\n        else if (Key < b[middle]) high = middle -1;\n        else low = middle+1;\n    }\n    return -1;\n}\nint main(void) {\n    int n_arr[10]={3,5,7,9,11,14,17,33,44,50};\n    printf("\\nSearching for 44 (Q16):\\n");\n    bsearch_q16(n_arr, 44, 0, 9);\n    printf("Total middle executions for Q16: %d\\n", middle_executions_q16);\n    return 0;\n}',
                'q17-code': '#include <stdio.h>\nint middle_executions_q17 = 0;\nint bsearch_q17(int b[], int Key, int low, int high){\n    int middle;\n    middle_executions_q17 = 0;\n    while (low <= high){\n        middle_executions_q17++;\n        middle=(low+high)/2;\n        printf("low=%d, high=%d, middle=%d, b[middle]=%d, executions=%d\\n", low, high, middle, b[middle], middle_executions_q17);\n        if (Key == b[middle]) return middle;\n        else if (Key < b[middle]) high = middle -1;\n        else low = middle+1;\n    }\n    return -1;\n}\nint main(void) {\n    int n_arr[10]={3,5,7,9,11,14,17,33,44,50};\n    printf("\\nSearching for 13 (Q17):\\n");\n    bsearch_q17(n_arr, 13, 0, 9);\n    printf("Total middle executions for Q17: %d\\n", middle_executions_q17);\n    return 0;\n}',
                'q18-code': '#include <stdio.h>\nint middle_executions_q18 = 0;\nint bsearch_q18(int b[], int Key, int low, int high){\n    int middle;\n    middle_executions_q18 = 0;\n    while (low <= high){\n        middle_executions_q18++;\n        middle=(low+high)/2;\n        // Special handling for out of bounds if key is too large/small and high/low cross aggressively\n        // For this problem, array is sorted and keys are within reasonable probing range or just outside.\n        printf("low=%d, high=%d, middle=%d, ", low, high, middle);\n        if (middle >=0 && middle <10) printf("b[middle]=%d, ", b[middle]); else printf("b[middle]=OOB, ");\n        printf("executions=%d\\n", middle_executions_q18);\n        if (Key == b[middle]) return middle;\n        else if (Key < b[middle]) high = middle -1;\n        else low = middle+1;\n    }\n    return -1;\n}\nint main(void) {\n    int n_arr[10]={3,5,7,9,11,14,17,33,44,50};\n    printf("\\nSearching for 55 (Q18):\\n");\n    bsearch_q18(n_arr, 55, 0, 9);\n    printf("Total middle executions for Q18: %d\\n", middle_executions_q18);\n    return 0;\n}',
                'q19-code': '#include <stdio.h>\nint abc(int x, int y){\n    int tmp;\n    while (x%y != 0){ tmp=y; y=x%y; x=tmp; }\n    return y;\n}\nint main(void){\n    int z=abc(159, 52);\n    printf("%d\\n", z);\n    return 0;\n}',
                'q20-code': '#include <stdio.h>\nint def(int x){\n    if (x==1) return 1;\n    else {\n        int i, B=0, A=1, O=0, S=0;\n        for (i=2;i<=x;i++){ S=A+B; O=S; B=A; A=S; }\n        return O;\n    }\n}\nint main(void){\n    int z=def(7);\n    printf("%d\\n", z);\n    return 0;\n}',
                'q22-code': '#include <stdio.h>\nvoid SubProgram(int x_val, int *y_ptr, int *z_ptr){\n    printf("In SubProgram: before: x_val=%d, *y_ptr=%d, *z_ptr=%d\\n", x_val, *y_ptr, *z_ptr);\n    x_val = x_val + *y_ptr - *z_ptr;\n    *y_ptr = x_val - *z_ptr - 1;\n    *z_ptr = x_val - *y_ptr;\n    printf("In SubProgram: after: x_val=%d, *y_ptr=%d, *z_ptr=%d\\n", x_val, *y_ptr, *z_ptr);\n}\nint main(void){\n    int x=12,y=8,z=4;\n    printf("In main: before: x=%d, y=%d, z=%d\\n", x, y, z);\n    SubProgram(x, &y, &z);\n    printf("Result from main: x=%d, y=%d, z=%d\\n", x, y, z);\n    return 0;\n}',
                'q23-code': '#include <stdio.h>\nint test(int a){\n    if (a<=1) return 1;\n    else return a*test(a-1);\n}\nint main(void){\n    int x_val=5, y_val=2;\n    int z_val=test(x_val)/test(y_val)*test(x_val-y_val);\n    printf("%d\\n", z_val);\n    return 0;\n}',
                'q24-code': '#include <stdio.h>\nint TestYou(int a){\n    if (a==1) return 0;\n    else return TestYou(a-1)+a*(a+1);\n}\nint main(void){\n    int a_val=5;\n    int b_val=TestYou(a_val);\n    printf("%d\\n", b_val);\n    return 0;\n}',
                'q25-code': '#include <stdio.h>\nint TestYou_gcd(int a, int b){\n    if (b==0) return a;\n    else return TestYou_gcd(b, a%b);\n}\nint main(void){\n    int c_val=TestYou_gcd(306, 68);\n    printf("%d\\n", c_val);\n    return 0;\n}'
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
