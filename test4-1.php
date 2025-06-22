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
    <title>C 語言 第四章 迴圈與條件練習 (WASM & MathJax)</title>

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
            overflow: hidden; /* 防止頁面本身滾動 */
        }
        .container {
            display: flex;
            max-width: 100%; /* 使用全部寬度 */
            height: 100vh; /* 佔滿整個視窗高度 */
            margin: 0 auto;
            padding: 0; /* 移除內邊距，由子元素控制 */
        }
        .tutorial-content { /* 左側視窗 ------------------------------------------------ */
            width: 70%; /* 初始寬度 */
            min-width: 350px; /* 最小寬度 */
            padding: 20px 40px;
            box-sizing: border-box;
            overflow-y: auto; /* 讓教學內容可以獨立滾動 */
            height: 100vh;
        }
        /* 新增：可拖曳的分隔線 */
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
        .interactive-panel {  /* 左側視窗 ------------------------------------------------ */
            width: 30%; /* 初始寬度 */
            min-width: 400px; /* 最小寬度 */
            flex-grow: 1; /* 佔據剩餘空間 */
            position: relative; /* 改為 relative */
            top: 0; /* 移除 top sticky 定位 */
            height: 100vh; /* 佔滿整個視窗高度 */
            padding: 20px;
            box-sizing: border-box;
        }

        h1, h2, h3 {
            color: var(--header-color);
            font-weight: 700;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
        }
        h1 { font-size: 2.5em; }
        h2 { font-size: 2em; margin-top: 40px; }
        h3 { font-size: 1.5em; margin-top: 30px; border-bottom: none; }
        p, ul {
            font-size: 1.1em;
        }
        ul {
            list-style-type: disc;
            padding-left: 20px;
        }
        li {
            margin-bottom: 10px;
        }
        code:not(pre > code) {
            background-color: var(--card-bg);
            color: var(--primary-color);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: var(--font-code);
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
            margin-left: 10px;
            font-size: 0.9em;
        }
        .run-example-btn:hover {
            background-color: #357ABD;
        }
        .knowledge-point {
            margin-bottom: 20px;
            padding: 15px;
            border-left: 4px solid var(--primary-color);
            background-color: rgba(74, 144, 226, 0.1);
        }
        /* Interactive Panel Styles */
        .sandbox-container {
            background-color: var(--card-bg);
            border-radius: 8px;
            padding: 20px;
            border: 1px solid var(--border-color);
            height: 100%; /* 佔滿父容器高度 */
            display: flex; /* 使用 Flexbox 佈局 */
            flex-direction: column;
        }
        .interactive-panel-inner {
            display: flex;
            flex-direction: column;
            height: 100%;
            gap: 20px;
        }
        .sandbox-container h3 {
            margin-top: 0;
            color: var(--primary-color);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
            flex-shrink: 0; /* 防止標題被壓縮 */
        }
        #code-editor {
            width: 100%;
            flex-grow: 1; /* 佔據大部分空間 */
            background-color: var(--code-bg);
            color: var(--text-color);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-family: var(--font-code);
            font-size: 0.9em; /* << 修改：再次縮小字體 */
            padding: 10px;
            box-sizing: border-box;
            resize: vertical;
            min-height: 150px; /* 最小高度 */
        }
        .sandbox-controls {
            display: flex;
            justify-content: flex-end;
            padding: 10px 0;
            flex-shrink: 0; /* 防止控制項被壓縮 */
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
            padding: 15px;
            border-radius: 4px;
            font-family: var(--font-code);
            white-space: pre-wrap;
            word-wrap: break-word;
            min-height: 80px;
            margin-top: 10px;
            flex-shrink: 0; /* 防止輸出區被壓縮 */
            font-size: 0.85em; /* << 修改：再次縮小字體 */
            overflow-y: auto; /* 新增：讓輸出區可以垂直滾動 */
            max-height: 250px; /* 設定最大高度，超過則滾動 */
        }
        /* Quiz Section Styles */
        .quiz-section {
            margin-top: 50px;
            background-color: transparent;
            border: none;
            padding: 0;
        }
        .quiz-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
            scroll-margin-top: 20px;
        }
        .quiz-card h3 {
            margin-top: 0;
            color: var(--header-color);
        }
        .quiz-options .option {
            display: block;
            background-color: #3c3c3c;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.3s, background-color 0.3s;
        }
        .quiz-options .option:hover {
            border-color: var(--primary-color);
        }
        .quiz-options .option.correct {
            border-color: var(--success-color);
            background-color: rgba(115, 201, 144, 0.2);
        }
        .quiz-options .option.incorrect {
            border-color: var(--error-color);
            background-color: rgba(244, 113, 116, 0.2);
        }
        .quiz-options .option.answered {
            cursor: default;
        }
        .quiz-options .option.answered:hover {
            border-color: transparent;
        }
        .quiz-options .option.correct.answered:hover {
             border-color: var(--success-color);
        }
         .quiz-options .option.incorrect.answered:hover {
             border-color: var(--error-color);
        }

        .explanation {
            display: none;
            margin-top: 20px;
            padding: 15px;
            background-color: var(--code-bg);
            border-radius: 5px;
        }
        .explanation h4 {
            margin-top: 0;
            color: var(--primary-color);
        }
        .explanation ul {
            padding-left: 20px;
        }
        .explanation ul li::marker {
            color: var(--primary-color);
        }
        .next-btn-container {
            text-align: right;
            margin-top: 20px;
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
            <h1>C 語言練習：第四章 迴圈、條件與綜合應用</h1>
            <p>本章節包含一系列關於 C 語言迴圈結構（<code>for</code>, <code>while</code>, <code>do-while</code>）、條件判斷（<code>if</code>, <code>switch</code>）、位元運算以及其他相關綜合應用的練習題。請仔細閱讀每個題目，並選擇最合適的答案。部分題目附有程式碼片段，您可以點擊「運行示例」按鈕，將程式碼載入到右側的沙箱中實際執行和測試，以幫助理解。每個問題的詳解中，對於迴圈相關題目，將提供變數變化追蹤表以釐清執行流程。</p>

            <div class="quiz-section">
                <h2>第四章 互動練習題</h2>
                <p>完成左側的學習後，試著挑戰下面的題目，檢驗你的學習成果！點擊選項後會顯示詳解。題目中的程式碼也可以點擊「運行示例」載入到右側沙箱中執行。</p>

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
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>k 的變化：6 -> 12 -> 24 -> 48 -> 96 -> 192。Printout 在 k < 100 時執行，所以共執行5次。</p>
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
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (A)</p>
                        <p>A OR B = 1000000. NOT B = 0111111. (A OR B) AND (NOT B) = 1000000 AND 0111111 = 0000000.</p>
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
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>當 i==j 時，內層 k 迴圈執行 j (或 i) 次。i 從 5 到 10。所以 count = 5 + 6 + 7 + 8 + 9 + 10 = 45。</p>
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
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>x 累加 n 的值，n 從 0 到 9。所以 x = 0+1+2+...+9 = 45。</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q5">下一題</button></div>
                </div>

                <div id="q5" class="quiz-card">
                    <h3>5. 下列程式碼，while 迴圈內 i = i ＊ i 被執行多少次？</h3>
                    <pre><code class="language-c">i= 2; while (i &lt; 800) {i = i * i;}</code></pre>
                    <button class="run-example-btn" data-code-id="q5-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 2</div>
                        <div class="option" data-option="B">(B) 3</div>
                        <div class="option" data-option="C">(C) 4</div>
                        <div class="option" data-option="D">(D) 5</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (C)</p>
                        <p>i 的變化：2 -> 4 -> 16 -> 256 -> 65536。迴圈在 i < 800 時執行。所以 i = i * i 執行了4次。</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q6">下一題</button></div>
                </div>

                <div id="q6" class="quiz-card">
                    <h3>6. 下列程式，印出多少個 happy？</h3>
                    <pre><code class="language-c">i = 1;
while (i &lt;= 10) puts("happy");</code></pre>
                    <button class="run-example-btn" data-code-id="q6-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 0</div>
                        <div class="option" data-option="B">(B) 1</div>
                        <div class="option" data-option="C">(C) 0</div>
                        <div class="option" data-option="D">(D) 無限個</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (D)</p>
                        <p>變數 i 在迴圈內沒有被改變，條件 i <= 10 恆成立，造成無限迴圈。</p>
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
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (D)</p>
                        <p>p 的變化：2 -> 4 -> 8 -> 16 -> 32 -> 64 -> 128 -> 256 -> 512 -> 1024 -> 2048。當 p=2048 時，p < 2000 不成立，迴圈結束，回傳 2048。</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q8">下一題</button></div>
                </div>

                <div id="q8" class="quiz-card">
                    <h3>8. 一個迴圈程式碼如下，其中 m = m / k 總共執行幾次？</h3>
                    <pre><code class="language-c">k = 2; m=10000;
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
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>k 的變化: 2 -> 6 -> 18 -> 54 -> 162。m = m / k 在 k < 120 時執行。共執行4次。</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q9">下一題</button></div>
                </div>

                <div id="q9" class="quiz-card">
                    <h3>9. 執行下列程式片段，請問最後 x 的值多少？</h3>
                    <pre><code class="language-c">int x = 50; int y = 90;
if (y&lt;95)
  if (y&lt;200) x = 30;
  else x =45;
printf("x = %d", x);</code></pre>
                    <button class="run-example-btn" data-code-id="q9-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 30</div>
                        <div class="option" data-option="B">(B) 50</div>
                        <div class="option" data-option="C">(C) 45</div>
                        <div class="option" data-option="D">(D) 90</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (A)</p>
                        <p>y=90。y < 95 (true)。進入內層 if。y < 200 (true)。所以 x = 30。</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q10">下一題</button></div>
                </div>

                <div id="q10" class="quiz-card">
                    <h3>10. 執行下列程式碼之後，請問最後 s 的值多少？</h3>
                    <pre><code class="language-c">int s = 0;
for (int i=2; i&lt;=100; i+=2) s+=i;
printf("s = %d", s);</code></pre>
                    <button class="run-example-btn" data-code-id="q10-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 5500</div>
                        <div class="option" data-option="B">(B) 2550</div>
                        <div class="option" data-option="C">(C) 5050</div>
                        <div class="option" data-option="D">(D) 2500</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>計算 2+4+6+...+100 的偶數和。S = (2+100)*50/2 = 102*25 = 2550。</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q11">下一題</button></div>
                </div>

                <div id="q11" class="quiz-card">
                    <h3>11. 執行下列程式後，請問最後 i 的值多少？</h3>
                    <pre><code class="language-c">int i;
for (i = 7; i &lt;= 72; i += 7)
  ;
printf("i is %d", i);</code></pre>
                    <button class="run-example-btn" data-code-id="q11-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 77</div>
                        <div class="option" data-option="B">(B) 70</div>
                        <div class="option" data-option="C">(C) 72</div>
                        <div class="option" data-option="D">(D) 7</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (A)</p>
                        <p>i 的變化: 7, 14, ..., 70. 當 i=70, i <= 72 (true), i 變成 77. 下次 i <= 72 (false), 迴圈結束. 印出 i=77.</p>
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
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (C)</p>
                        <p>在布林代數中，A+A = A (Idempotent Law for OR)。所以 A+A+A = (A+A)+A = A+A = A。</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q16">下一題</button></div>
                </div>

                <div id="q16" class="quiz-card">
                    <h3>16. 一個迴圈程式碼： k = 10000， while (k >=2) { k=k/8， } 其中 k=k/8 總共會執行幾次？</h3>
                    <pre><code class="language-c">/* Conceptual code, direct execution might differ based on integer division
int k = 10000;
int count = 0;
while (k >= 2) {
    k = k / 8;
    count++;
}
// printf("%d", count);
*/</code></pre>
                    <button class="run-example-btn" data-code-id="q16-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 3 次</div>
                        <div class="option" data-option="B">(B) 4 次</div>
                        <div class="option" data-option="C">(C) 5 次</div>
                        <div class="option" data-option="D">(D) 6 次</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (C)</p>
                        <p>k 的變化: 10000 -> 1250 -> 156 -> 19 -> 2 -> 0. 執行 k=k/8 的次數為 5 次 (當 k=2, 2>=2 true, k=2/8=0, count++)。</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q17">下一題</button></div>
                </div>

                <div id="q17" class="quiz-card">
                    <h3>17. 下列程式碼，while 迴圈內 i = i ＊ i 被執行多少次？</h3>
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
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (C)</p>
                        <p>i 的變化：2 -> 4 -> 16 -> 256 -> 65536。i=i*i 執行4次。</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q18">下一題</button></div>
                </div>

                <div id="q18" class="quiz-card">
                    <h3>18. 執行下列 c 程式片段，請問最後輸出是？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
void main(){
  int number=1061130, result;
  do {
    result = number %10;
    printf("%i", result);
    number = number/10;
  } while(number != 0);
}</code></pre>
                    <button class="run-example-btn" data-code-id="q18-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 1061130</div>
                        <div class="option" data-option="B">(B) 0311601</div>
                        <div class="option" data-option="C">(C) 106113</div>
                        <div class="option" data-option="D">(D) 311601</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>程式會反向印出數字的每一位：0, 3, 1, 1, 6, 0, 1。</p>
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
printf("sum=%d", sum);</code></pre>
                    <button class="run-example-btn" data-code-id="q19-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 325</div>
                        <div class="option" data-option="B">(B) 1300</div>
                        <div class="option" data-option="C">(C) 625</div>
                        <div class="option" data-option="D">(D) 2600</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>計算 4+8+12+...+100。這是一個等差數列，首項4，末項100，公差4。項數 = (100-4)/4 + 1 = 24 + 1 = 25。總和 = (4+100)*25/2 = 104*25/2 = 52*25 = 1300。</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q21">下一題</button></div>
                </div>

                <div id="q21" class="quiz-card">
                    <h3>21. 已知一個迴圈程式碼：k=2， while(k&lt;=65535) k=k＊k， 估計其中 k=k＊k 總共執行多少次？</h3>
                    <pre><code class="language-c">/* Conceptual:
int k=2;
int count = 0;
while(k&lt;=65535) {
    k=k*k;
    count++;
}
// printf("%d", count);
*/</code></pre>
                    <button class="run-example-btn" data-code-id="q21-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 4 次</div>
                        <div class="option" data-option="B">(B) 5 次</div>
                        <div class="option" data-option="C">(C) 6 次</div>
                        <div class="option" data-option="D">(D) 7 次</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (A)</p>
                        <p>k 的變化: 2 -> 4 -> 16 -> 256 -> 65536. 當 k=65536, k<=65535 is false. 所以 k=k*k 執行了4次.</p>
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
printf("%d\n", n);</code></pre>
                    <button class="run-example-btn" data-code-id="q22-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 2000</div>
                        <div class="option" data-option="B">(B) 2500</div>
                        <div class="option" data-option="C">(C) 5000</div>
                        <div class="option" data-option="D">(D) 10000</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>計算 1+3+5+...+99 的奇數和。首項1，末項99，公差2。項數 = (99-1)/2 + 1 = 49+1 = 50。總和 = (1+99)*50/2 = 100*25 = 2500。</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q24">下一題</button></div>
                </div>

                <div id="q24" class="quiz-card">
                    <h3>24. 執行下列 c 程式後，請問 y3 最後輸出是？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int y1, y2=13, y3=1;
  for (y1=0; y1&lt;=y2; y3){ // Note: y3 is not incremented in the for loop's increment part
    y3 += y1;
    y1 += 2;
  }
  printf("%i", y3);
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
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>y1 values: 0, 2, 4, 6, 8, 10, 12. y3 accumulates these: 1 (initial) + 0 + 2 + 4 + 6 + 8 + 10 + 12 = 1+42 = 43.</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q25">下一題</button></div>
                </div>

                <div id="q25" class="quiz-card">
                    <h3>25. 在程式片段中，若輸入 n 為 1234，請問執行結果為何？</h3>
                    <pre><code class="language-c">int  n; int sum=0;
scanf("%d", &n); // Assume n = 1234
while(n!=0){
  sum=sum+n%10;
  n=n/10;
}
printf("%d\n", sum);</code></pre>
                    <p><sub>(註：右側沙箱不支援 `scanf`，請自行推算或修改為靜態賦值 `int n=1234;`)</sub></p>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 1234</div>
                        <div class="option" data-option="B">(B) 10</div>
                        <div class="option" data-option="C">(C) 1</div>
                        <div class="option" data-option="D">(D) 4</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>程式計算各位數字和：4+3+2+1 = 10。</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q26">下一題</button></div>
                </div>

                <div id="q26" class="quiz-card">
                    <h3>26. 執行下列程式碼後，請問輸出結果為？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
main(){ // Should be int main()
  int x=110, y=20;
  while(x>120){ // Condition is initially false
    y=x-y;
    x++;
  }
  printf("%3d%3d", x, y);
}</code></pre>
                    <button class="run-example-btn" data-code-id="q26-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 111 90</div>
                        <div class="option" data-option="B">(B) 112 21</div>
                        <div class="option" data-option="C">(C) 110 90</div>
                        <div class="option" data-option="D">(D) 110 20</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (D)</p>
                        <p>The while loop condition `x > 120` (110 > 120) is false from the start. The loop body never executes. So x remains 110, y remains 20.</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q27">下一題</button></div>
                </div>

                <div id="q27" class="quiz-card">
                    <h3>27. 執行下列程式碼後，請問輸出結果為？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
main(){ // Should be int main()
  int x=0, y=0;
  for(y=1; y&lt;=20; y++) {
    int z=y%5;
    if(z==0) x++;
  }
  printf("%3d%3d",x,y);
}</code></pre>
                    <button class="run-example-btn" data-code-id="q27-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 0 0</div>
                        <div class="option" data-option="B">(B) 4 21</div>
                        <div class="option" data-option="C">(C) 2 11</div>
                        <div class="option" data-option="D">(D) 3 11</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>x counts multiples of 5 from 1 to 20 (5, 10, 15, 20), so x becomes 4. The loop for y runs until y is 21 (condition y&lt;=20 fails). Output is "  4 21".</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q28">下一題</button></div>
                </div>

                <div id="q28" class="quiz-card">
                    <h3>28. 執行下列程式碼後，請問輸出結果為？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
main(){ // Should be int main()
  int a=5, b=2;
  if(a>b){ // 5 > 2 is true
    a=a*b+2; // a = 5*2+2 = 12
    b++;     // b = 3
  } else {
    a=a/2;
    b=b+4;
  }
  printf("%3d%3d",a,b);
}</code></pre>
                    <button class="run-example-btn" data-code-id="q28-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 8 2</div>
                        <div class="option" data-option="B">(B) 12 3</div>
                        <div class="option" data-option="C">(C) 2 6</div>
                        <div class="option" data-option="D">(D) 4 6</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>Since a > b (5 > 2) is true, the if block executes. a becomes 5*2+2 = 12. b becomes 2+1 = 3. Output: " 12  3".</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q29">下一題</button></div>
                </div>

                <div id="q29" class="quiz-card">
                    <h3>29. 執行下列程式碼後，請問輸出結果為？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
main(){ // Should be int main()
  int n=4, x=7, y=8;
  switch(n){
    case 1: x=n;break;
    case 2: y=y+4;
    case 3: x=n+5;break;
    case 4: x=x*4;   // x = 7*4 = 28. No break, falls through.
    default: y=y-4;  // y = 8-4 = 4.
  }
  printf("%2d%2d",x,y);
}</code></pre>
                    <button class="run-example-btn" data-code-id="q29-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 28 4</div>
                        <div class="option" data-option="B">(B) 4 8</div>
                        <div class="option" data-option="C">(C) 9 12</div>
                        <div class="option" data-option="D">(D) 9 8</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (A)</p>
                        <p>n=4. `case 4` matches. x becomes 7*4=28. No break, so it falls through to `default`. y becomes 8-4=4. Output: "28 4".</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q30">下一題</button></div>
                </div>

                <div id="q30" class="quiz-card">
                    <h3>30. 執行下列程式碼後，請問輸出結果為？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
main(){ // Should be int main()
  int x=30, y;
  if (x&lt;=5) { // 30 &lt;= 5 is false
    y=x*x; // x^2 is not C syntax for square, but the block is skipped
    x+=5;
  } else { // This block executes
    if (x&lt;10) { // 30 &lt; 10 is false
      y=x-2;
    } else { // This block executes
      if(x&lt;25) { // 30 &lt; 25 is false
        y=x+10;
      } else { // This block executes
        y=x/10; // y = 30/10 = 3
      }
    }
    x++; // x = 30+1 = 31
  }
  printf("%3d%3d",y,x);
}</code></pre>
                    <button class="run-example-btn" data-code-id="q30-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 28 31</div>
                        <div class="option" data-option="B">(B) 40 31</div>
                        <div class="option" data-option="C">(C) 3 31</div>
                        <div class="option" data-option="D">(D) 900 35</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (C)</p>
                        <p>x=30. First if (x&lt;=5) is false. Else branch taken. Inner if (x&lt;10) is false. Its else branch taken. Inner if (x&lt;25) is false. Its else branch taken. y = x/10 = 30/10 = 3. Then x++ makes x=31. Output: "  3 31".</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q31">下一題</button></div>
                </div>

                <div id="q31" class="quiz-card">
                    <h3>31. 當執行下列程式碼並輸入一串數值 5 2 -1 10 後，請問輸出結果為？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
main(){ // Should be int main()
  int x=3, y=6, z=0;
  printf("請輸入一串數值："); // Assuming this doesn't affect sandbox execution
  do{
    scanf("%d", &z); // Loop 1: z=5; Loop 2: z=2; Loop 3: z=-1; Loop 4: z=10
    x = x+z+y;       // L1: x=3+5+6=14 | L2: x=14+2+7=23 | L3: x=23-1+8=30 | L4: x=30+10+9=49
    y++;             // L1: y=7        | L2: y=8        | L3: y=9         | L4: y=10
  } while(z&lt;10);     // L1: 5&lt;10 T   | L2: 2&lt;10 T   | L3: -1&lt;10 T    | L4: 10&lt;10 F -> Loop ends
  y *= 2;            // y = 10*2 = 20
  printf("%3d%3d%3d",z,x,y); // z=10, x=49, y=20
}</code></pre>
                    <p><sub>(註：右側沙箱不支援 `scanf`，請自行推算或修改為靜態賦值模擬輸入)</sub></p>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 10 49 20</div>
                        <div class="option" data-option="B">(B) 10 48 20</div>
                        <div class="option" data-option="C">(C) 10 45 18</div>
                        <div class="option" data-option="D">(D) 10 3 6</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (A)</p>
                        <p>Trace execution:
                        1. z=5: x=3+5+6=14, y=7. (5<10 true)
                        2. z=2: x=14+2+7=23, y=8. (2<10 true)
                        3. z=-1: x=23-1+8=30, y=9. (-1<10 true)
                        4. z=10: x=30+10+9=49, y=10. (10<10 false). Loop terminates.
                        y = y*2 = 10*2 = 20. Output: z=10, x=49, y=20.</p>
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
printf("sum=%d", sum);</code></pre>
                    <button class="run-example-btn" data-code-id="q32-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 2000</div>
                        <div class="option" data-option="B">(B) 2525</div>
                        <div class="option" data-option="C">(C) 5050</div>
                        <div class="option" data-option="D">(D) 10100</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (D)</p>
                        <p>Sum of even numbers from 0 to 200: 0+2+...+200.
                        This is an arithmetic series. Number of terms = (200-0)/2 + 1 = 101.
                        Sum = (First + Last) * NumTerms / 2 = (0 + 200) * 101 / 2 = 200 * 101 / 2 = 100 * 101 = 10100.</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q33">下一題</button></div>
                </div>

                <div id="q33" class="quiz-card">
                    <h3>33. 在下列的程式片段中，請問執行結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int a=1;
  while(++a&lt;5){ // Pre-increment
    printf("%d ", a);
  }
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
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (C)</p>
                        <p>1. a=1. ++a -> a=2. 2<5 (true). Print 2.
                        2. ++a -> a=3. 3<5 (true). Print 3.
                        3. ++a -> a=4. 4<5 (true). Print 4.
                        4. ++a -> a=5. 5<5 (false). Loop ends.
                        Output: "2 3 4 ". </p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q34">下一題</button></div>
                </div>

                <div id="q34" class="quiz-card">
                    <h3>34. 在下列的程式片段中，請問執行結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main(){
  int a=1;
  while(a++&lt;5){ // Post-increment
    printf("%d ", a);
  }
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
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (D)</p>
                        <p>1. a=1. a++<5 (1<5 true), then a becomes 2. Print a (which is 2).
                        2. a=2. a++<5 (2<5 true), then a becomes 3. Print a (which is 3).
                        3. a=3. a++<5 (3<5 true), then a becomes 4. Print a (which is 4).
                        4. a=4. a++<5 (4<5 true), then a becomes 5. Print a (which is 5).
                        5. a=5. a++<5 (5<5 false). Loop ends.
                        Output: "2 3 4 5 ". (The dot in options is a typo from source)</p>
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
  }while(++a&lt;5); // Pre-increment in condition
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
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (A)</p>
                        <p>1. a=1. Print 1. ++a -> a=2. 2<5 (true).
                        2. Print 2. ++a -> a=3. 3<5 (true).
                        3. Print 3. ++a -> a=4. 4<5 (true).
                        4. Print 4. ++a -> a=5. 5<5 (false). Loop ends.
                        Output: "1 2 3 4 ". (The dot in options is a typo from source)</p>
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
  }while(a++&lt;5); // Post-increment in condition
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
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>1. a=1. Print 1. a++<5 (1<5 true), then a becomes 2.
                        2. a=2. Print 2. a++<5 (2<5 true), then a becomes 3.
                        3. a=3. Print 3. a++<5 (3<5 true), then a becomes 4.
                        4. a=4. Print 4. a++<5 (4<5 true), then a becomes 5.
                        5. a=5. Print 5. a++<5 (5<5 false), then a becomes 6. Loop ends.
                        Output: "1 2 3 4 5 ". (The dot in options is a typo from source)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q37">下一題</button></div>
                </div>

                <div id="q37" class="quiz-card">
                    <h3>37. 在下列的程式片段中，是利用輾轉相除法來求得 m 與 n 的最大公因數，請問迴圈內的敘述應該為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;

int main(){
  int m,n,r;
  // Assume scanf populates m and n
  // Example: m=48, n=18
  // r = m % n; // r = 48 % 18 = 12
  while (r != 0){
    // MISSING LOGIC
    // Iteration 1: r=12. We need m=18, n=12. Then r = 18 % 12 = 6.
    // Iteration 2: r=6. We need m=12, n=6. Then r = 12 % 6 = 0. Loop ends. n=6 is GCD.
    // Correct logic: m becomes n, n becomes r, then r is recalculated.
  }
  // printf("%d\n", n);
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
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (D)</p>
                        <p>The question states `r = m % n;` is calculated *before* the `while (r != 0)` loop.
                        Inside the loop, to continue the Euclidean algorithm:
                        The old `n` becomes the new `m`.
                        The old `r` (which was `m_old % n_old`) becomes the new `n`.
                        Then, the new `r` is calculated as `m_new % n_new`.
                        This matches option (D): `m = n; n = r; r = m % n;`</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q38">下一題</button></div>
                </div>

                <div id="q38" class="quiz-card">
                    <h3>38. 請問下列程式片段執行後，會印出什麼？</h3>
                    <pre><code class="language-c">// Assuming main() and stdio.h
// int main() {
  int x=2, y=0;
  for (y=1; y&lt;=30; y++){
    int z=y%6;
    if (z==0) x+=2;
  }
  printf("%3d%3d", x, y);
// }</code></pre>
                    <button class="run-example-btn" data-code-id="q38-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 5 31</div>
                        <div class="option" data-option="B">(B) 15 31</div>
                        <div class="option" data-option="C">(C) 10 31</div>
                        <div class="option" data-option="D">(D) 12 31</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (D)</p>
                        <p>y goes from 1 to 30. x (initially 2) increments by 2 when y is a multiple of 6 (6, 12, 18, 24, 30). There are 5 such multiples. So x = 2 + 5*2 = 12. After the loop, y is 31. Output: " 12 31".</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q39">下一題</button></div>
                </div>

                <div id="q39" class="quiz-card">
                    <h3>39. 請問下列程式片段執行後，輸出的第 12 個數值是？</h3>
                    <pre><code class="language-c">// Assuming main() and stdio.h and bool type (stdbool.h)
// #include &lt;stdbool.h&gt;
// int main() {
  int p,d;
  bool flag; // Or int flag;
  int count = 0;
  for (p=2; p&lt;=50; ++p){ // Prints prime numbers
    flag = 1; // true
    for (d=2; d&lt;p; ++d)
      if (p%d == 0) flag=0; // false
    if (flag != 0) {
      // printf("%i ", p); // Outputting primes
      count++;
      // if (count == 12) printf("\n12th prime is %d\n", p);
    }
  }
// }</code></pre>
                    <button class="run-example-btn" data-code-id="q39-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 31</div>
                        <div class="option" data-option="B">(B) 37</div>
                        <div class="option" data-option="C">(C) 41</div>
                        <div class="option" data-option="D">(D) 43</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>The code prints prime numbers up to 50.
                        Primes: 2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47.
                        The 12th prime number in this sequence is 37.</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q40">下一題</button></div>
                </div>

                <div id="q40" class="quiz-card">
                    <h3>40. 下列 cIc++程式片段之敘述，何者正確？</h3>
                    <pre><code class="language-c">// Assuming iostream for cin/cout if C++
// Or stdio.h for scanf/printf if C
// Example interpretation (C++):
// #include &lt;iostream&gt;
// int main() {
  int a,b,c;
  std::cin >> a; // cin needs iostream
  std::cin >> b;
  c=a;
  if (b>c) c=b;
  // std::cout&lt;&lt;"the output is:"&lt;&lt;c;
// }
// This finds the maximum of a and b.
</code></pre>
                    <button class="run-example-btn" data-code-id="q40-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 找出輸入數值最小值</div>
                        <div class="option" data-option="B">(B) 找出輸入數值最大值</div>
                        <div class="option" data-option="C">(C) 輸入三個變數</div>
                        <div class="option" data-option="D">(D) 輸出結果為 the output is.c</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>The code reads two numbers `a` and `b`. It initializes `c` with `a`. Then, if `b` is greater than `c` (which is `a`), it updates `c` to `b`. So, `c` will hold the maximum of `a` and `b`.</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q41">下一題</button></div>
                </div>

                <div id="q41" class="quiz-card">
                    <h3>41. 在下列的程式片段中，中間的 13~16 行的 if 該如何寫，可以將 x， y， z 三個數由小到大排序？</h3>
                    <pre><code class="language-c">1.	#include &lt;stdio.h&gt;
2.
3.	int main(){
4.	  int x, y, z;
5.	  int temp;
6.	  // scanf("%d%d%d", &x, &y, &z); // Assume x,y,z are initialized
7.	  if(x>y){ // Ensures x &lt;= y
8.	    temp = x; x = y; y = temp;
9.	  }
10.	  // Now x &lt;= y
11.	  // We need to place z correctly.
12.   // Goal: x &lt;= y &lt;= z
13.	  // MISSING IF BLOCK
14.
15.
16.	  // After this missing block, one more if(x>y) is done.
17.	  // This implies the missing block might involve y and z.
18.	  if (x>y){ // This final swap ensures the smallest is in x.
19.	    temp = x; x = y; y = temp;
20.	  }
21.	  // printf("%d %d %d\n", x, y, z);
22.	  return 0;
23. }</code></pre>
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
temp = z; z = x; // Error: z = z should be z = x
x = temp;
}</code></pre></div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>This is a simple bubble sort pass.
                        1. First `if(x>y)` ensures `x <= y`.
                        2. The missing `if` should ensure `y <= z` (relative to the current y). So, `if (y > z)` swap `y` and `z`. (Option B)
                           After this, `x` is the smallest of original x,y. And `y <= z`. (Actually, after this step, we have original_x/y in x, and original_y/z in y, and original_z/y in z, such that current x <= current y, and current y <= current z).
                        3. The final `if(x>y)` ensures that if `z` (now in `y` if it was smallest of `y,z`) is smaller than `x`, it gets moved to `x`.
                        This sequence correctly sorts three numbers: smallest in x, middle in y, largest in z.</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q42">下一題</button></div>
                </div>

                <div id="q42" class="quiz-card">
                    <h3>42. 在下面的程式片段中 8~10 行，while 迴圈該如何撰寫，可以計算輸入的整數 n 每個位數的總和，例如輸入 1234，輸出 10。</h3>
                    <pre><code class="language-c">1.	#include &lt;stdio.h&gt;
2.
3.	int main(){
4.	  int n;
5.	  int sum = 0;
6.	  // scanf("%d", &n); // Assume n is initialized e.g., n=1234
7.
8.	  // while(){ // MISSING LOOP
9.	  //
10. // }
11.
12.	  // printf("%d\n", sum);
13.	  return 0;
14. }</code></pre>
                    <button class="run-example-btn" data-code-id="q42-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) <pre><code class='language-markup'>while(n != 0){
n /= 10; // Error: n is modified before sum += n%10
sum += n%10;
}</code></pre></div>
                        <div class="option" data-option="B">(B) <pre><code class='language-markup'>while(n/10 != 0){ // Error: last digit missed if n is single digit. e.g. n=7
sum += n%10;
n /= 10;
}</code></pre></div>
                        <div class="option" data-option="C">(C) <pre><code class='language-markup'>while(n != 0){
sum = n%10; // Error: sum is overwritten, not accumulated
n /= 10;
}</code></pre></div>
                        <div class="option" data-option="D">(D) <pre><code class='language-markup'>while(n != 0){
sum += n%10;
n /= 10;
}</code></pre></div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (D)</p>
                        <p>To sum digits of n:
                        Loop while n is not 0.
                        In each step, add the last digit (n % 10) to sum.
                        Then remove the last digit from n (n = n / 10).
                        Option (D) correctly implements this.</p>
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
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (C)</p>
                        <p>k is initialized to 10. The while condition is `k == 0`. Since 10 is not equal to 0, the condition is false from the start, and the loop body is never executed.</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q44">下一題</button></div>
                </div>

                <div id="q44" class="quiz-card">
                    <h3>44. 請問下面 c 程式中，printf("＼n")共被執灖幾次？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main() {
  for (int i=1; i&lt;=4; i++){ // Outer loop runs 4 times (i=1,2,3,4)
    for (int j=1; j&lt;5; j++) // Inner loop runs 4 times (j=1,2,3,4)
      printf("*");
    printf("\n"); // This is executed once per outer loop iteration
  }
}</code></pre>
                    <button class="run-example-btn" data-code-id="q44-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 4</div>
                        <div class="option" data-option="B">(B) 5</div>
                        <div class="option" data-option="C">(C) 8</div>
                        <div class="option" data-option="D">(D) 16</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (A)</p>
                        <p>The outer loop (for i) runs 4 times. The `printf("\n")` statement is inside the outer loop but outside the inner loop. Thus, it executes once for each iteration of the outer loop, for a total of 4 times.</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q45">下一題</button></div>
                </div>

                <div id="q45" class="quiz-card">
                    <h3>45. 請問下列程式執行後，輸出結果為？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main() {
  float salary = 400.0;
  if (salary > 400.0){ // 400.0 > 400.0 is false
    float bonus = 10.0;
    salary += bonus;
  } else { // This block executes
    salary += salary * 0.2; // salary = 400.0 + 400.0 * 0.2 = 400.0 + 80.0 = 480.0
  }
  printf("%.2f", salary);
}</code></pre>
                    <button class="run-example-btn" data-code-id="q45-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 410.000000</div>
                        <div class="option" data-option="B">(B) 410.00</div>
                        <div class="option" data-option="C">(C) 480.00</div>
                        <div class="option" data-option="D">(D) 480.00000</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (C)</p>
                        <p>salary is 400.0. The condition `salary > 400.0` is false. The else block executes: `salary = salary + salary * 0.2` which is `400.0 + 80.0 = 480.0`. Output is formatted to two decimal places: "480.00".</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q46">下一題</button></div>
                </div>

                <div id="q46" class="quiz-card">
                    <h3>46. 請問以下程式，所輸出的第 3 個結果為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main() {
  int n=4, a=1;
  for (int i=1; i&lt;=n; i++){ // i from 1 to 4
    for (int c=1; c&lt;=i; c++){ // c from 1 to i
      printf("%d", a);
      a++;
    }
    printf("\n"); // This is the "result" referred to
  }
}
// Output:
// 1
// 23
// 456  <- 3rd result
// 78910
</code></pre>
                    <button class="run-example-btn" data-code-id="q46-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 456</div>
                        <div class="option" data-option="B">(B) 23</div>
                        <div class="option" data-option="C">(C) 1</div>
                        <div class="option" data-option="D">(D) 78910</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (A)</p>
                        <p>The program prints lines of incrementing numbers.
                        1st line (i=1): prints `a` (1), then newline. `a` becomes 2.
                        2nd line (i=2): prints `a` (2), `a` (3), then newline. `a` becomes 4.
                        3rd line (i=3): prints `a` (4), `a` (5), `a` (6), then newline. `a` becomes 7. The output for this line is "456".
                        This is the 3rd "result" (line printed).</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q47">下一題</button></div>
                </div>

                <div id="q47" class="quiz-card">
                    <h3>47. 根據右側之流程圖分析，當程式執行到最後一個列印方塊時，下列敘述何者正確？</h3>
                    <p><sub>(流程圖未提供，假設是指一個標準的迭代求和或計數過程)</sub></p>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 程式結束時，K = 45</div>
                        <div class="option" data-option="B">(B) 程式結束時，Q = 11</div>
                        <div class="option" data-option="C">(C) 這是一個迴圈程式，迴圈內程式總共執行 9 次</div>
                        <div class="option" data-option="D">(D) 程式結束時，Y = 10</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (A)</p>
                        <p>由於流程圖未提供，此題無法直接分析。答案 (A) 被選為正確答案是基於題目來源的解答。一個可能的流程圖是累加 K from 0 to 9 (K = 0+1+...+9 = 45)。</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q48">下一題</button></div>
                </div>

                <div id="q48" class="quiz-card">
                    <h3>48. 下列 c 語言程式碼片段執行後，變數 y 的值為何？</h3>
                    <pre><code class="language-c">int y, a=45;
if(a>=60)       // 45 >= 60 is false
  y=a+1;
else if(a>=50)  // 45 >= 50 is false
  y=a+2;
else            // This block executes
  y=a+3;        // y = 45 + 3 = 48
</code></pre>
                    <button class="run-example-btn" data-code-id="q48-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 45</div>
                        <div class="option" data-option="B">(B) 46</div>
                        <div class="option" data-option="C">(C) 47</div>
                        <div class="option" data-option="D">(D) 48</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (D)</p>
                        <p>a=45. `a>=60` is false. `a>=50` is false. The final `else` block is executed. y = a+3 = 45+3 = 48.</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q49">下一題</button></div>
                </div>

                <div id="q49" class="quiz-card">
                    <h3>49. 下列 C 語言程式碼片段執行結果，變數 total 的值為何？</h3>
                    <pre><code class="language-c">int i, total=0;
for( i=1; i&lt;8; i+=2) // i values: 1, 3, 5, 7
  total+=i;         // total: 0+1=1; 1+3=4; 4+5=9; 9+7=16
</code></pre>
                    <button class="run-example-btn" data-code-id="q49-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 4</div>
                        <div class="option" data-option="B">(B) 8</div>
                        <div class="option" data-option="C">(C) 16</div>
                        <div class="option" data-option="D">(D) 28</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (C)</p>
                        <p>The loop iterates for i = 1, 3, 5, 7.
                        total = 0 + 1 = 1
                        total = 1 + 3 = 4
                        total = 4 + 5 = 9
                        total = 9 + 7 = 16.</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q50">下一題</button></div>
                </div>

                <div id="q50" class="quiz-card">
                    <h3>50. 下列 C 語言程式碼片段執行結果，變數 y 的值為何？</h3>
                    <pre><code class="language-c">int y, r, a=30, b=42;
r=a%b; // r = 30 % 42 = 30
while(r!=0) {
  a=b;    // a=42 (iter1) | a=30 (iter2)
  b=r;    // b=30 (iter1) | b=12 (iter2)
  r=a%b;  // r=42%30=12 (iter1) | r=30%12=6 (iter2)
}
// Loop ends when r=0. This happens after r=a%b calculates 0.
// Iter3: a=12, b=6. r = 12%6 = 0. Loop terminates.
y=b; // y = 6 (GCD)
</code></pre>
                    <button class="run-example-btn" data-code-id="q50-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 42</div>
                        <div class="option" data-option="B">(B) 30</div>
                        <div class="option" data-option="C">(C) 12</div>
                        <div class="option" data-option="D">(D) 6</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (D)</p>
                        <p>This is the Euclidean algorithm for GCD.
                        1. a=30, b=42. r = 30%42 = 30.
                        2. (r=30!=0) a=42, b=30, r=42%30 = 12.
                        3. (r=12!=0) a=30, b=12, r=30%12 = 6.
                        4. (r=6!=0) a=12, b=6, r=12%6 = 0.
                        Loop terminates. y = b = 6.</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q51">下一題</button></div>
                </div>

                <div id="q51" class="quiz-card">
                    <h3>51. 阿華想要了解 C 語言程式 if 條件敘述中常用的運算子&與&&的不同，撰寫如下程式，下列何者為程式執行結果？</h3>
                    <pre><code class="language-c">1	#include &lt;stdio.h&gt;
2
3	int main() {
4
5	  int a=0x0a; // a = 10 (binary 1010)
6	  int b=0x05; // b = 5  (binary 0101)
7
8	  if(a & b)   // a & b = (1010 & 0101) = 0000 = 0 (false)
9	    printf("a&b=%d\n", a&b);
10	  else        // This else block is executed
11	    printf("a&&b=%d\n", a&&b); // a&&b = (true && true) = 1
12
13	  return 0;
14	}</code></pre>
                    <button class="run-example-btn" data-code-id="q51-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) a&&b=1</div>
                        <div class="option" data-option="B">(B) a&&b=0</div>
                        <div class="option" data-option="C">(C) a&b=1</div>
                        <div class="option" data-option="D">(D) a&b=0</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (A)</p>
                        <p>a = 10 (0x0A), b = 5 (0x05).
                        Bitwise AND: `a & b` is `1010 & 0101` which is `0000` (decimal 0).
                        The if condition `(a & b)` evaluates to `if(0)`, which is false.
                        So, the else block is executed.
                        It prints `a&&b=%d`.
                        Logical AND: `a && b` is `10 && 5`. Since both are non-zero (true), `a && b` is true (evaluates to 1).
                        Output: "a&&b=1".</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q52">下一題</button></div>
                </div>

                <div id="q52" class="quiz-card">
                    <h3>52. 曉華想要知道三角函數 sin(x)在 x=0 之後遞增的變化情形，寫了如下的 C 語言程式碼，卻發現迴圈內行號 8 和行號 9 的程式碼只執行了一次，下列哪一種修改程式的方式可以讓迴圈內的程式碼多執行幾次？ (提示：sin(1)=0.8415)</h3>
                    <pre><code class="language-c">1	#include &lt;stdio.h&gt;
2	#include &lt;math.h&gt;
3	// int x = 100; // This is a global x, shadowed by local x in main
4	int main(){
5	  int x = 0;
6	  double y = 0.0;
7	  do{
8	    y = 10*sin(x); // x is int, sin expects double. x is promoted.
                       // x=0: sin(0)=0, y=0.
                       // x=1: sin(1)=0.8415, y=8.415
9	    printf("x=%d, y=%lf\n", x,	y);
10	  } while(++x &lt;= y); // x=0 -> y=0. Loop 1: prints x=0,y=0. Condition: ++x (x=1) <= y (0) -> 1 <= 0 is false. Loop ends.
11	  printf("end of program\n");
12	  return 0;
13	}</code></pre>
                    <button class="run-example-btn" data-code-id="q52-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 把行號 3 中的 x=100 改為 x=0</div>
                        <div class="option" data-option="B">(B) 把行號 10 中的++x 改為 x++</div>
                        <div class="option" data-option="C">(C) 把行號 6 中 y 的初始值改為 –1.0</div>
                        <div class="option" data-option="D">(D) 把行號 3 中 x 的初始值改為 1</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (B)</p>
                        <p>Original loop:
                        x=0, y=0.
                        1. Print x=0, y=0.0. Condition: `++x` (x becomes 1). `1 <= y` (1 <= 0.0) is false. Loop terminates.
                        With (B) `x++ <= y`:
                        x=0, y=0.
                        1. Print x=0, y=0.0. Condition: `x++` (evaluates to 0, then x becomes 1). `0 <= y` (0 <= 0.0) is true.
                        2. x=1. y = 10*sin(1) = 8.415. Print x=1, y=8.415. Condition: `x++` (evaluates to 1, then x becomes 2). `1 <= y` (1 <= 8.415) is true.
                        3. x=2. y = 10*sin(2) = 9.09 (approx). Print x=2, y=9.09. Condition `x++` (evaluates to 2, then x becomes 3). `2 <= y` (2 <= 9.09) is true.
                        This allows more iterations.</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q53">下一題</button></div>
                </div>

                <div id="q53" class="quiz-card">
                    <h3>53. 如下 C 語言程式，當程式執行完畢後，輸出為何？</h3>
                    <pre><code class="language-c">1	#include &lt;stdio.h&gt;
2
3	int main(){
4	  unsigned char i=3; // binary 00000011
5	  switch ( (i&0x0e) % 5){ // 0x0e is 1110. i&0x0e = 0011 & 1110 = 0010 (2). (2) % 5 = 2.
6	    case(1):
7	      printf("%c", '0'+i);
8	      break;
9	    case(2): // This case matches
10	      printf("%c", '0'+i*i); // '0'+3*3 = '0'+9 = '9'. Prints '9'. No break.
11	    case(3): // Falls through
12	      printf("%c", 'a'+i*i); // 'a'+3*3 = 'a'+9 = 'j'. Prints 'j'. No break.
13	    default: // Falls through
14	      printf("%c", 'z');     // Prints 'z'.
15	  }
16	  return(0);
17	}</code></pre>
                    <button class="run-example-btn" data-code-id="q53-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 9jz</div>
                        <div class="option" data-option="B">(B) 927z</div>
                        <div class="option" data-option="C">(C) 9270</div>
                        <div class="option" data-option="D">(D) 9</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 正確答案</h4>
                        <p>本題的正確答案是： (A)</p>
                        <p>i = 3 (binary 0011).
                        0x0e = 14 (binary 1110).
                        `i & 0x0e` = `0011 & 1110` = `0010` (decimal 2).
                        `(i & 0x0e) % 5` = `2 % 5` = `2`.
                        Switch expression is 2.
                        `case(2)` matches. Prints '0' + 3*3 = '0'+9 = '9'. No `break`.
                        Falls through to `case(3)`. Prints 'a' + 3*3 = 'a'+9 = 'j'. No `break`.
                        Falls through to `default`. Prints 'z'.
                        Output: "9jz".</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q1">回到第一題</button></div>
                </div>

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
                'q9-code': `#include <stdio.h>\n\nint main() {\n    int x = 50; int y = 90;\n    if (y<95) {\n      if (y<200) x = 30;\n      else x =45;\n    } // Original code has ambiguous 'else', assuming it pairs with inner 'if'.\n      // For clarity, added braces. If 'else' was for outer 'if', x would be 50.\n    printf("x = %d\\n", x);\n    return 0;\n}`,
                'q10-code': `#include <stdio.h>\n\nint main() {\n    int s = 0;\n    for (int i=2; i<=100; i+=2) s+=i;\n    printf("s = %d\\n", s);\n    return 0;\n}`,
                'q11-code': `#include <stdio.h>\n\nint main() {\n    int i;\n    for (i = 7; i <= 72; i += 7)\n      ;\n    printf("i is %d\\n", i);\n    return 0;\n}`,
                'q16-code': `#include <stdio.h>\n\nint main() {\n    int k = 10000;\n    int count = 0;\n    while (k >= 2) {\n        k = k / 8;\n        count++;\n    }\n    printf("k=k/8 executed %d times. Final k=%d\\n", count, k);\n    return 0;\n}`,
                'q17-code': `#include <stdio.h>\n\nint main() {\n    int i=2;\n    int executions = 0;\n    while(i<800) {\n        i=i*i;\n        executions++;\n    }\n    printf("i=i*i executed %d times. Final i=%d\\n", executions, i);\n    return 0;\n}`,
                'q18-code': `#include <stdio.h>\n\n// void main() is not standard C, should be int main()\nint main(){\n  int number=1061130, result;\n  do {\n    result = number %10;\n    printf("%i", result); // %i is same as %d for printf\n    number = number/10;\n  } while(number != 0);\n  printf("\\n"); // Added for clarity\n  return 0;\n}`,
                'q19-code': `#include <stdio.h>\n\nint main() {\n    int x=4; int sum=0;\n    while (x<=100){\n      sum+=x;\n      x+=4;\n    }\n    printf("sum=%d\\n", sum);\n    return 0;\n}`,
                'q21-code': `#include <stdio.h>\n\nint main() {\n    int k=2;\n    int count = 0;\n    unsigned long long current_k = k; // Use unsigned long long to avoid overflow during k*k
    // The problem implies k is int, so k*k can overflow.
    // For estimation as in question, we track theoretical values.
    // 2 -> 4 -> 16 -> 256 -> 65536.
    // Iteration 1: k=2. 2<=65535. k=2*2=4. count=1.
    // Iteration 2: k=4. 4<=65535. k=4*4=16. count=2.
    // Iteration 3: k=16. 16<=65535. k=16*16=256. count=3.
    // Iteration 4: k=256. 256<=65535. k=256*256=65536. count=4.
    // Iteration 5: k=65536. 65536<=65535 is FALSE. Loop terminates.
    // So, k=k*k executes 4 times.

    // Actual execution if int overflows:
    k=2;
    count = 0;
    while(k <= 65535 && k > 0) { // added k > 0 to stop if overflow leads to non-positive
        if ( ( (long long)k * k ) > 2147483647 && sizeof(int) == 4 ) { // Approx check for int overflow
             // printf("Potential overflow if k (%d) is squared.\\n", k);
        }
        k=k*k;
        count++;
        if (k==0) break; // Break if overflow results in 0, to avoid infinite loop
        // printf("k is now %d after %d executions\\n", k, count);
    }
    printf("k=k*k executed %d times.\\n", count);
    return 0;\n}`,
                'q22-code': `#include <stdio.h>\n\nint main() {\n    int n=0; int i=1;\n    while(i<=100){\n      n=n+i;\n      i=i+2;\n    }\n    printf("%d\\n", n);\n    return 0;\n}`,
                'q24-code': `#include <stdio.h>\n\nint main(){\n  int y1, y2=13, y3=1;\n  for (y1=0; y1<=y2; ){ // y3 is not in increment part\n    y3 += y1;\n    y1 += 2;\n  }\n  printf("%i\\n", y3);\n  return 0;\n}`,
                'q26-code': `#include <stdio.h>\n\nint main(){ // Corrected main signature\n  int x=110, y=20;\n  while(x>120){\n    y=x-y;\n    x++;\n  }\n  printf("%3d%3d\\n", x, y);\n  return 0;\n}`,
                'q27-code': `#include <stdio.h>\n\nint main(){ // Corrected main signature\n  int x=0, y=0;\n  for(y=1; y<=20; y++) {\n    int z=y%5;\n    if(z==0) x++;\n  }\n  printf("%3d%3d\\n",x,y);\n  return 0;\n}`,
                'q28-code': `#include <stdio.h>\n\nint main(){ // Corrected main signature\n  int a=5, b=2;\n  if(a>b){\n    a=a*b+2;\n    b++;\n  } else {\n    a=a/2;\n    b=b+4;\n  }\n  printf("%3d%3d\\n",a,b);\n  return 0;\n}`,
                'q29-code': `#include <stdio.h>\n\nint main(){ // Corrected main signature\n  int n=4, x=7, y=8;\n  switch(n){\n    case 1: x=n;break;\n    case 2: y=y+4;\n    case 3: x=n+5;break;\n    case 4: x=x*4;\n    default: y=y-4;\n  }\n  printf("%2d%2d\\n",x,y);\n  return 0;\n}`,
                'q30-code': `#include <stdio.h>\n\nint main(){ // Corrected main signature\n  int x=30, y=0; // Initialize y\n  if (x<=5) {\n    y=x*x; \n    x+=5;\n  } else {\n    if (x<10) y=x-2;\n    else {\n      if(x<25) y=x+10;\n      else y=x/10;\n    }\n    x++;\n  }\n  printf("%3d%3d\\n",y,x);\n  return 0;\n}`,
                'q31-code': `#include <stdio.h>\n\nint main(){\n  int x=3, y=6, z=0;\n  // Simulating scanf inputs: 5 2 -1 10\n  int inputs[] = {5, 2, -1, 10};\n  int input_idx = 0;\n\n  // printf("請輸入一串數值："); // Original scanf line\n  do{\n    z = inputs[input_idx++]; // Simulating scanf("%d", &z);\n    // printf("Read z: %d\\n", z); \n    x = x+z+y;\n    y++;\n    // printf("x=%d, y=%d, z=%d\\n", x,y,z);\n  } while(z<10);\n  y *= 2;\n  printf("%3d%3d%3d\\n",z,x,y);\n  return 0;\n}`,
                'q32-code': `#include <stdio.h>\n\nint main() {\n    int x=0; int sum=0;\n    while(x <= 200){\n      sum += x;\n      x += 2;\n    }\n    printf("sum=%d\\n", sum);\n    return 0;\n}`,
                'q33-code': `#include <stdio.h>\n\nint main(){\n  int a=1;\n  while(++a<5){\n    printf("%d ", a);\n  }\n  printf("\\n");\n  return 0;\n}`,
                'q34-code': `#include <stdio.h>\n\nint main(){\n  int a=1;\n  while(a++<5){\n    printf("%d ", a);\n  }\n  printf("\\n");\n  return 0;\n}`,
                'q35-code': `#include <stdio.h>\n\nint main(){\n  int a=1;\n  do{\n    printf("%d ", a);\n  }while(++a<5);\n  printf("\\n");\n  return 0;\n}`,
                'q36-code': `#include <stdio.h>\n\nint main(){\n  int a=1;\n  do{\n    printf("%d ", a);\n  }while(a++<5);\n  printf("\\n");\n  return 0;\n}`,
                'q37-code': `#include <stdio.h>\n\nint main(){\n  int m,n,r;\n  // Simulating scanf for m=48, n=18 (example for GCD 6)\n  m=48; n=18;\n  printf("Initial m=%d, n=%d\\n", m, n);\n  r = m % n;\n  printf("Initial r = m %% n = %d\\n", r);\n  while (r != 0){\n    // Option D logic:\n    m = n;\n    n = r;\n    r = m % n;\n    printf("Inside loop: m=%d, n=%d, r=%d\\n", m,n,r);\n  }\n  printf("GCD (n) = %d\\n", n);\n  return 0;\n}`,
                'q38-code': `#include <stdio.h>\n\nint main(){ // Corrected main signature\n  int x=2, y=0;\n  for (y=1; y<=30; y++){\n    int z=y%6;\n    if (z==0) x+=2;\n  }\n  printf("%3d%3d\\n", x, y);\n  return 0;\n}`,
                'q39-code': `#include <stdio.h>\n#include <stdbool.h>\n\nint main(){ // Corrected main signature\n  int p,d;\n  bool flag;\n  int count = 0;\n  int twelfth_prime = 0;\n  printf("Prime numbers: ");\n  for (p=2; p<=50; ++p){\n    flag = true;\n    for (d=2; d<p; ++d) {\n      if (p%d == 0) {\n        flag=false;\n        break; // Optimization\n      }\n    }\n    if (flag) {\n      // printf("%i ", p); // Uncomment to see all primes\n      count++;\n      if (count == 12) {\n        twelfth_prime = p;\n      }\n    }\n  }\n  // printf("\\n");\n  printf("The 12th prime is: %d\\n", twelfth_prime);\n  return 0;\n}`,
                'q40-code': `#include <stdio.h>\n\n// Simulating C++ cin/cout with C scanf/printf for this example\nint main() {\n  int a,b,c;\n  printf("Enter two integers a and b: ");\n  // Simulating cin >> a >> b;\n  // For testing, let's use fixed values, e.g., a=5, b=10\n  a = 5; b = 10;\n  printf("Assuming a=%d, b=%d\\n",a,b);\n\n  c=a;\n  if (b>c) c=b;\n  printf("the output is:%d\\n",c);\n  return 0;\n}`,
                'q41-code': `#include <stdio.h>\n\nint main(){\n  int x, y, z;\n  int temp;\n  // Simulate scanf for x=5, y=2, z=8. Expected sort: 2, 5, 8\n  x=5; y=2; z=8;\n  printf("Original: x=%d, y=%d, z=%d\\n", x,y,z);\n\n  if(x>y){ // x=5,y=2 -> true. temp=5, x=2, y=5. Now x=2,y=5,z=8\n    temp = x; x = y; y = temp;\n    printf("After first swap: x=%d, y=%d, z=%d\\n", x,y,z);\n  }\n\n  // Option B logic:\n  if (y > z){ // y=5,z=8 -> false. No swap here.\n    temp = y; y = z; z = temp;\n    // printf("After second (potential) swap: x=%d, y=%d, z=%d\\n", x,y,z);\n  }\n\n  if (x>y){ // x=2,y=5 -> false. No swap here.\n    temp = x; x = y; y = temp;\n    // printf("After third (potential) swap: x=%d, y=%d, z=%d\\n", x,y,z);\n  }\n  printf("Sorted: %d %d %d\\n", x, y, z);\n  return 0;\n}`,
                'q42-code': `#include <stdio.h>\n\nint main(){\n  int n;\n  int sum = 0;\n  // Simulate scanf for n=1234\n  n=1234;\n  printf("n=%d\\n", n);\n\n  // Option D logic:\n  while(n != 0){\n    sum += n%10;\n    n /= 10;\n    // printf("sum=%d, n=%d\\n", sum, n);\n  }\n\n  printf("Sum of digits: %d\\n", sum);\n  return 0;\n}`,
                'q44-code': `#include <stdio.h>\n\nint main() {\n  int newline_count = 0;\n  for (int i=1; i<=4; i++){\n    for (int j=1; j<5; j++)\n      printf("*");\n    printf("\\n");\n    newline_count++;\n  }\n  printf("printf(\\"\\n\\") executed %d times.\\n", newline_count);\n  return 0;\n}`,
                'q45-code': `#include <stdio.h>\n\nint main() {\n  float salary = 400.0;\n  if (salary > 400.0){\n    float bonus = 10.0;\n    salary += bonus;\n  } else {\n    salary += salary * 0.2;\n  }\n  printf("%.2f\\n", salary);\n  return 0;\n}`,
                'q46-code': `#include <stdio.h>\n\nint main() {\n  int n=4, a=1;\n  int line_count = 0;\n  for (int i=1; i<=n; i++){\n    for (int c=1; c<=i; c++){\n      printf("%d", a);\n      a++;\n    }\n    printf("\\n");\n    line_count++;\n    if(line_count == 3) {\n        // This is to capture the 3rd line for verification if needed\n        // but the question asks for the printed value on 3rd line which is 456\n    }\n  }\n  return 0;\n}`,
                'q48-code': `#include <stdio.h>\n\nint main() {\n    int y=0, a=45; // Initialize y\n    if(a>=60)\n      y=a+1;\n    else if(a>=50)\n      y=a+2;\n    else\n      y=a+3;\n    printf("y = %d\\n", y);\n    return 0;\n}`,
                'q49-code': `#include <stdio.h>\n\nint main() {\n    int i, total=0;\n    for( i=1; i<8; i+=2)\n      total+=i;\n    printf("total = %d\\n", total);\n    return 0;\n}`,
                'q50-code': `#include <stdio.h>\n\nint main() {\n    int y, r, a=30, b=42;\n    r=a%b;\n    while(r!=0) {\n      a=b;\n      b=r;\n      r=a%b;\n    }\n    y=b;\n    printf("y (GCD) = %d\\n", y);\n    return 0;\n}`,
                'q51-code': `#include <stdio.h>\n\nint main() {\n  int a=0x0a; \n  int b=0x05; \n  if(a & b)\n    printf("a&b=%d\\n", a&b);\n  else\n    printf("a&&b=%d\\n", a&&b);\n  return 0;\n}`,
                'q52-code': `#include <stdio.h>\n#include <math.h>\n\nint main(){\n  int x_orig = 0;\n  double y_orig = 0.0;\n  int count_orig = 0;\n  printf("Original loop:\\n");\n  do{\n    y_orig = 10*sin(x_orig);\n    printf("x=%d, y=%lf\\n", x_orig, y_orig);\n    count_orig++;\n  } while(++x_orig <= y_orig && count_orig < 5); // Added count_orig to prevent infinite loop in demo\n  if (count_orig >=5) printf("Original loop limited for demo.\\n");\n\n  int x_mod = 0;\n  double y_mod = 0.0;\n  int count_mod = 0;\n  printf("\\nModified loop (B - x++ <= y):\\n");\n  do{\n    y_mod = 10*sin(x_mod);\n    printf("x=%d, y=%lf\\n", x_mod, y_mod);\n    count_mod++;\n  } while(x_mod++ <= y_mod && count_mod < 5); // Added count_mod for demo safety\n  if (count_mod >=5) printf("Modified loop limited for demo.\\n");\n\n  printf("end of program\\n");\n  return 0;\n}`,
                'q53-code': `#include <stdio.h>\n\nint main(){\n  unsigned char i=3;\n  switch ( (i&0x0e) % 5){\n    case(1):\n      printf("%c", '0'+i);\n      break;\n    case(2):\n      printf("%c", '0'+i*i);\n    case(3):\n      printf("%c", 'a'+i*i);\n    default:\n      printf("%c", 'z');\n  }\n  printf("\\n"); // For clarity\n  return(0);\n}`
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

            // --- <<<< 最終修正：使用 onload 事件確保 iframe 準備就緒 >>>> ---
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

                    // *** 關鍵修正：使用 onload 事件 ***
                    // 這可以確保 iframe 內部文檔已完全載入並準備好，才能開始操作它
                    iframe.onload = () => {
                        const iframeWindow = iframe.contentWindow;

                        // 1. 將資料和通訊函式安全地掛載到 iframe 的 window 上
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
                            iframe.remove(); // 清理 iframe
                            runCodeBtn.disabled = false; // 成功執行完畢，解鎖按鈕
                        };

                        // 2. 準備一個"啟動器"腳本，注入到 iframe 中
                        const bootstrapScript = iframe.contentDocument.createElement('script');
                        bootstrapScript.textContent = `
                            window.Module = {
                                wasmBinary: window.EMCC_WASM_BINARY,
                                print: (text) => window.parentPrint(text),
                                printErr: (text) => window.parentPrintError(text),
                                onRuntimeInitialized: () => {
                                    setTimeout(() => window.parentSignalEnd(), 50);
                                }
                            };

                            const scriptElement = document.createElement('script');
                            scriptElement.textContent = window.EMCC_JS_CODE;
                            document.body.appendChild(scriptElement);
                        `;

                        // 3. 將啟動器注入到準備好的 iframe 中
                        iframe.contentDocument.body.appendChild(bootstrapScript);
                    };

                    // 將 iframe 新增到 DOM 中，這將觸發上面的 onload 事件
                    document.body.appendChild(iframe);

                } catch (e) {
                    outputArea.textContent = '請求或執行時發生錯誤：\n\n' + e.message + '\n\n請確認您的本機後端編譯服務 (http://localhost:3000/compile) 已正確啟動。';
                    runCodeBtn.disabled = false; // 若 fetch 或 json 解析失敗，解鎖按鈕
                }
            });


            // --- Quiz Logic ---
            document.querySelectorAll('.quiz-options').forEach(optionsContainer => {
                optionsContainer.addEventListener('click', function(e) {
                    if (e.target.classList.contains('option') && !this.classList.contains('answered')) {
                        const selectedOption = e.target;
                        const correctAnswer = this.getAttribute('data-correct');
                        const selectedAnswer = selectedOption.getAttribute('data-option');

                        this.classList.add('answered');

                        const options = this.querySelectorAll('.option');
                        options.forEach(opt => {
                           const optValue = opt.getAttribute('data-option');
                           let marker = '';
                           if(optValue === correctAnswer){
                               opt.classList.add('correct');
                               marker = ' ✅';
                           } else if (optValue === selectedAnswer) {
                               opt.classList.add('incorrect');
                               marker = ' ❌';
                           }
                           opt.innerHTML += marker;
                           opt.classList.add('answered');
                        });

                        const explanation = this.nextElementSibling;
                        if (explanation && explanation.classList.contains('explanation')) {
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

            // --- 左右拉動調整寬度邏輯 ---
            const resizer = document.getElementById('dragMe');
            const leftSide = document.querySelector('.tutorial-content');
            const rightSide = document.querySelector('.interactive-panel');

            const mouseDownHandler = function (e) {
                // 獲取當前滑鼠位置
                let x = e.clientX;
                let leftWidth = leftSide.getBoundingClientRect().width;

                // 增加一個覆蓋層防止拖曳時選取到 iframe 或其他元素
                const overlay = document.createElement('div');
                overlay.style.position = 'fixed';
                overlay.style.top = '0';
                overlay.style.left = '0';
                overlay.style.width = '100%';
                overlay.style.height = '100%';
                overlay.style.cursor = 'col-resize';
                overlay.style.zIndex = '9999';
                document.body.appendChild(overlay);

                // 將事件監聽器附加到 document
                document.addEventListener('mousemove', mouseMoveHandler);
                document.addEventListener('mouseup', mouseUpHandler);

                function mouseMoveHandler(e) {
                    const dx = e.clientX - x;
                    const newLeftWidth = leftWidth + dx;

                    // 應用寬度變化
                    leftSide.style.width = `${newLeftWidth}px`;
                    // 右側會因 flex-grow: 1 自動調整
                }

                function mouseUpHandler() {
                    // 移除覆蓋層和監聽器
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
