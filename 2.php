<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C 語言互動教學 (Emscripten & WASM)</title>

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
            <h1>C 語言核心概念</h1>
            <p>本章節將帶您深入了解 C 語言最基礎也最重要的構成元素：資料型態、變數、常數，以及如何與使用者進行基本的互動。</p>

            <h2 id="topic-2-1">2-1 資料型態</h2>
            <div class="knowledge-point">
                <h3>字面值 (Literal)</h3>
                <p>C 語言將字面上表示的各種文字與數值，通稱為<strong>字面值 (Literal)</strong>，它們是直接寫在程式碼中的固定值。</p>
                <ul>
                    <li><strong>字元 (character)</strong>: 單一符號，用單引號 <code>' '</code> 括起來，如 <code>'c'</code>、<code>'2'</code>、<code>'#'</code>。</li>
                    <li><strong>字串 (string)</strong>: 0 個以上的字元序列，用雙引號 <code>" "</code> 括起來，如 <code>"My Friend!"</code>、<code>"C++ 語言"</code>。</li>
                    <li><strong>整數 (integer)</strong>: 包含 0 和正、負整數。
                        <ul>
                            <li>10 進制: 如 <code>11</code>、<code>-8</code>。</li>
                            <li>8 進制: 使用數字 <code>0</code> 開頭，如 <code>013</code> (等於十進制的 11)。</li>
                            <li>16 進制: 使用 <code>0x</code> 開頭，如 <code>0x0b</code> (等於十進制的 11)。</li>
                        </ul>
                    </li>
                    <li><strong>浮點數 (float)</strong>: 包含小數點的數字，如 <code>12.34</code>、<code>1234e-4</code> (<code>e</code> 表示以 10 為底的指數，即 $1234 \times 10^{-4}$，結果為 0.1234)。</li>
                </ul>
            </div>

            <p>在宣告變數時，需指定變數的<strong>資料型態 (Data Type)</strong>，以便編譯器為其配置適當的記憶體空間。電腦儲存資料的最小單位是<strong>位元 (Bit)</strong>，而 1 個<strong>位元組 (Byte)</strong> 等於 8 個位元。</p>

            <h3>基本資料型態</h3>
            <h4>(1) 整數資料型態</h4>
            <table>
                <thead>
                    <tr><th>資料型態</th><th>說明</th><th>所需記憶體空間</th><th>能表示的資料範圍</th></tr>
                </thead>
                <tbody>
                    <tr><td><code>short int</code></td><td>短整數</td><td>2 bytes</td><td>-32768 ~ 32767</td></tr>
                    <tr><td><code>unsigned short int</code></td><td>無號短整數</td><td>2 bytes</td><td>0 ~ 65535</td></tr>
                    <tr><td><code>int</code></td><td>整數</td><td>4 bytes</td><td>-2,147,483,648 ~ 2,147,483,647</td></tr>
                    <tr><td><code>unsigned int</code></td><td>無號整數</td><td>4 bytes</td><td>0 ~ 4,294,967,295</td></tr>
                    <tr><td><code>long int</code></td><td>長整數</td><td>4 bytes</td><td>-2,147,483,648 ~ 2,147,483,647</td></tr>
                    <tr><td><code>unsigned long int</code></td><td>無號長整數</td><td>4 bytes</td><td>0 ~ 4,294,967,295</td></tr>
                </tbody>
            </table>
            <p class="table-note">註：在現代 64 位元系統中，<code>long int</code> 通常為 8 bytes。上表為常見 32 位元系統的標準。<code>short int</code> 可簡寫為 <code>short</code>，<code>long int</code> 可簡寫為 <code>long</code>。</p>

            <h4>(2) 浮點數資料型態</h4>
            <table>
                <thead>
                    <tr><th>資料型態</th><th>說明</th><th>所需記憶體空間</th><th>能表示的資料範圍 (約略)</th></tr>
                </thead>
                <tbody>
                    <tr><td><code>float</code></td><td>單精度浮點數</td><td>4 bytes</td><td>$1.17 \times 10^{-38} \sim 3.40 \times 10^{38}$</td></tr>
                    <tr><td><code>double</code></td><td>雙精度浮點數</td><td>8 bytes</td><td>$2.22 \times 10^{-308} \sim 1.79 \times 10^{308}$</td></tr>
                    <tr><td><code>long double</code></td><td>倍精度浮點數</td><td>16 bytes</td><td>$3.36 \times 10^{-4932} \sim 1.18 \times 10^{4932}$</td></tr>
                </tbody>
            </table>

            <h4>(3) 字元資料型態</h4>
            <table>
                <thead>
                    <tr><th>資料型態</th><th>說明</th><th>所需記憶體空間</th><th>能表示的資料範圍</th></tr>
                </thead>
                <tbody>
                    <tr><td><code>char</code></td><td>英文字母、數字、符號、ASCII碼</td><td>1 byte</td><td>-128 ~ 127</td></tr>
                    <tr><td><code>unsigned char</code></td><td>無號字元 (常用於二進位資料)</td><td>1 byte</td><td>0 ~ 255</td></tr>
                </tbody>
            </table>

            <h4>(4) 布林資料型態 (C++ 特有)</h4>
            <table>
                <thead>
                    <tr><th>資料型態</th><th>說明</th><th>所需記憶體空間</th><th>值</th></tr>
                </thead>
                <tbody>
                    <tr><td><code>bool</code></td><td>表示真或假</td><td>1 byte</td><td><code>true</code> (1) 或 <code>false</code> (0)</td></tr>
                </tbody>
            </table>
            <p class="table-note">註：標準 C 語言沒有布林 (boolean) 資料型態，而是約定俗成地使用數值 <code>0</code> 表示 false，任何非 <code>0</code> 的數值表示 true。</p>

            <h3>字串與複合資料型態</h3>
            <ul>
                <li>C 語言沒有原生的字串 (string) 資料型態，若要表示字串，需使用<strong>字元陣列</strong> (<code>char array</code>) 來替代。</li>
                <li>C++ 語言則提供了方便的 <code>string</code> 資料型態，使用前需引用 <code>&lt;string&gt;</code> 函式庫。</li>
                <li><strong>複合資料型態</strong>包含：列舉 (<code>enum</code>)、陣列 (<code>array</code>)、結構 (<code>struct</code>)、聯合 (<code>union</code>) 等，這些是更複雜的資料組織方式。</li>
            </ul>

            <h2 id="topic-2-2">2-2 變數與常數宣告</h2>
            <div class="knowledge-point">
                <h3>變數 (Variable)</h3>
                <p>程式執行時使用的資料，會暫時儲存在記憶體中，這些用來儲存資料的具名記憶體空間稱為<strong>變數</strong>。在使用變數前，必須先進行<strong>宣告</strong>，以定義變數的名稱與資料型態。</p>
                <h4>宣告語法</h4>
                <pre><code class="language-c">資料型態 變數名稱;
資料型態 變數名稱 = 初始值;</code></pre>
                <button class="run-example-btn" data-code-id="varDeclare">運行示例</button>
            </div>

            <div class="knowledge-point">
                <h3>識別字 (Identifier) 命名規則</h3>
                <p>變數名稱必需是合法的<strong>識別字</strong>，需符合下列規則：</p>
                <ul>
                    <li>可使用英文字母、阿拉伯數字、底線 <code>_</code>。</li>
                    <li>不可以使用特殊字元 (如 <code>@, #, %, -, *</code> 等)。</li>
                    <li>不能以阿拉伯數字開頭 (例如 <code>1var</code> 是錯誤的)。</li>
                    <li>英文的大小寫有區別 (<code>myVar</code> 和 <code>myvar</code> 是不同變數)。</li>
                    <li>不能使用 C 語言的關鍵字或保留字 (如 <code>int</code>, <code>if</code>, <code>return</code>)。</li>
                </ul>
            </div>

            <div class="knowledge-point">
                <h3>sizeof 運算子</h3>
                <p>使用 <code>sizeof</code> 運算子，可以取得變數或資料型態所需的記憶體大小 (單位為 byte)。</p>
                <pre><code class="language-c">double d = 3.14;
int a = 10;
// sizeof(d) 的結果為 8
// sizeof(int) 的結果通常為 4</code></pre>
                <button class="run-example-btn" data-code-id="sizeofOperator">運行示例</button>
            </div>

            <div class="knowledge-point">
                <h3>常數 (Constant)</h3>
                <p>常數的內容在定義後即固定，程式執行過程中不可改變。有兩種主要定義方式：</p>
                <h4>1. `const` 關鍵字</h4>
                <p>這是宣告常數的首選方法，它會建立一個具有型別的唯讀變數。</p>
                <pre><code class="language-c">const 資料型態 常數名稱 = 值;</code></pre>
                <button class="run-example-btn" data-code-id="constKeyword">運行示例</button>

                <h4>2. `#define` 前置處理指令</h4>
                <p>在編譯前將程式中所有識別字替換為標記字串，結尾不需分號。</p>
                <pre><code class="language-c">#define 識別字 標記字串</code></pre>
                <button class="run-example-btn" data-code-id="defineDirective">運行示例</button>

                <h4>3. `enum` 列舉型態</h4>
                <p>使用列舉 (enumeration) 可建立一組具名的整數常數。若未指定，成員值預設從 0 開始遞增。</p>
                <pre><code class="language-c">enum 列舉名稱 { 成員1, 成員2, ... };</code></pre>
                <button class="run-example-btn" data-code-id="enumType">運行示例</button>
            </div>

            <h2 id="topic-2-3">2-3 基本輸入／輸出</h2>
            <p>使用 C 語言的標準輸入/輸出函式 (如 `printf`, `scanf`) 之前，必須先引用 <code>&lt;stdio.h&gt;</code> 標頭檔。</p>

            <h3>格式化字元</h3>
            <table>
                <thead>
                    <tr><th>格式字元</th><th>對應資料型態</th></tr>
                </thead>
                <tbody>
                    <tr><td><code>%d</code> 或 <code>%i</code></td><td>10 進制整數 (int)</td></tr>
                    <tr><td><code>%u</code></td><td>10 進制無號整數 (unsigned int)</td></tr>
                    <tr><td><code>%o</code></td><td>8 進制無號數</td></tr>
                    <tr><td><code>%x</code></td><td>16 進制無號數</td></tr>
                    <tr><td><code>%ld</code></td><td>長整數 (long int)</td></tr>
                    <tr><td><code>%f</code></td><td>浮點數 (float/double)</td></tr>
                    <tr><td><code>%c</code></td><td>字元 (char)</td></tr>
                    <tr><td><code>%s</code></td><td>字串 (字元陣列)</td></tr>
                    <tr><td><code>%p</code></td><td>指標位址</td></tr>
                </tbody>
            </table>

            <h3>跳脫字元 (Escape Sequence)</h3>
             <table>
                <thead>
                    <tr><th>跳脫字元</th><th>說明</th></tr>
                </thead>
                <tbody>
                    <tr><td><code>\n</code></td><td>換行 (New Line)</td></tr>
                    <tr><td><code>\t</code></td><td>水平 Tab 鍵</td></tr>
                    <tr><td><code>\\</code></td><td>輸出反斜線 <code>\</code></td></tr>
                    <tr><td><code>\'</code></td><td>輸出單引號 <code>'</code></td></tr>
                    <tr><td><code>\"</code></td><td>輸出雙引號 <code>"</code></td></tr>
                    <tr><td><code>\?</code></td><td>輸出問號 <code>?</code></td></tr>
                </tbody>
            </table>

            <div class="knowledge-point">
                <h3>輸出函式 `printf()`</h3>
                <p>`printf()` 可以將格式化的字串與變數內容輸出到螢幕上。</p>
                <pre><code class="language-c">#include &lt;stdio.h&gt;

int main() {
    int t = 25;
    int rh = 72;

    // 直接輸出字串，並以 \n 換行
    printf("今天天氣很好\n");

    // 透過 %d 格式字元，輸出變數 t 的內容
    printf("溫度 %d 度\n", t);

    // 輸出多個變數
    printf("溫度 %d 度，濕度 %d%%\n", t, rh); // 要輸出 '%' 字元需使用 '%%'

    return 0;
}</code></pre>
                <button class="run-example-btn" data-code-id="printfExample">運行示例</button>
            </div>

            <div class="knowledge-point">
                <h3>控制輸出寬度與精度</h3>
                <p>在 <code>%</code> 後面加上數字可以控制最小輸出寬度，不足時會補上空白字元 (或 <code>0</code>)。對於浮點數，可使用 <code>.</code> 來指定小數點後的位數。</p>
                <pre><code class="language-c">printf("|%d|\n", 7);     // |7|
printf("|%3d|\n", 7);    // |  7|
printf("|%03d|\n", 7);   // |007|
printf("|%.2f|\n", 1.234); // |1.23|
printf("|%5.2f|\n", 1.234);// | 1.23|</code></pre>
                <button class="run-example-btn" data-code-id="printfFormatting">運行示例</button>
            </div>

            <div class="knowledge-point">
                <h3>輸入函式 `scanf()`</h3>
                <p>`scanf()` 從鍵盤讀取使用者輸入，並存入指定變數的記憶體位址。因此，變數前必須加上<strong>取址運算子 `&`</strong>。</p>
                <pre><code class="language-c">#include &lt;stdio.h&gt;

int main() {
    int age;
    int height, weight;

    printf("請輸入您的年齡: ");
    scanf("%d", &age); // 輸入一個整數，存入 age 變數

    printf("請輸入身高(cm)與體重(kg)，以空白隔開: ");
    scanf("%d %d", &height, &weight); // 輸入兩個整數

    printf("您輸入的資訊：\n");
    printf("年齡: %d 歲\n", age);
    printf("身高: %d cm, 體重: %d kg\n", height, weight);

    return 0;
}</code></pre>
                <button class="run-example-btn" data-code-id="scanfExample">運行示例</button>
            </div>

            <p><em>註：C++ 中也常用 <code>cout</code> 和 <code>cin</code> 進行輸出入，它們屬於 <code>&lt;iostream&gt;</code> 的一部分，用法更為直觀，但此處專注於 C 語言標準。</em></p>

            <div id="quiz" class="quiz-section">
                <h2>互動題庫</h2>
                <p>檢驗一下您的學習成果吧！點擊選項作答。</p>

                <div id="q1" class="quiz-card">
                    <h3>1. 在 C 語言中，下列何者不是合法的變數名稱 (Identifier)？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A"><code>_totalCount</code></div>
                        <div class="option" data-option="B"><code>level_2</code></div>
                        <div class="option" data-option="C"><code>2_level</code></div>
                        <div class="option" data-option="D"><code>Player1</code></div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 考點說明：識別字命名規則</h4>
                        <p>C 語言的識別字只能由英文字母、數字和底線組成，且<strong>不能以數字開頭</strong>。</p>
                        <h4>✗ 錯誤選項原因</h4>
                        <ul>
                            <li><b>(A) <code>_totalCount</code>:</b> 以底線開頭，合法。</li>
                            <li><b>(B) <code>level_2</code>:</b> 由字母、底線、數字組成，合法。</li>
                            <li><b>(C) <code>2_level</code>:</b> 以數字開頭，因此是<strong>不合法</strong>的變數名稱。</li>
                            <li><b>(D) <code>Player1</code>:</b> 由字母和數字組成，且非數字開頭，合法。</li>
                        </ul>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q2">下一題</button></div>
                </div>

                <div id="q2" class="quiz-card">
                    <h3>2. 執行 <code>printf("%04d", 58);</code> 後，輸出的結果是什麼？</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A"><code>58</code></div>
                        <div class="option" data-option="B"><code>0058</code></div>
                        <div class="option" data-option="C"><code>  58</code> (前面有2個空格)</div>
                        <div class="option" data-option="D"><code>5800</code></div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 考點說明：`printf` 格式化輸出</h4>
                        <p>格式化字串 <code>%04d</code> 的意思是：</p>
                        <ul>
                            <li><code>d</code>: 以十進位整數形式輸出。</li>
                            <li><code>4</code>: 輸出的最小寬度為 4 個字元。</li>
                            <li><code>0</code>: 如果實際數字的位數小於指定的寬度(4)，則在左邊用 <code>0</code> 填充。</li>
                        </ul>
                        <p>因此，數字 <code>58</code> 只有兩位，寬度不足 4 位，所以會在左邊填充兩個 <code>0</code>，得到 <code>0058</code>。</p>
                        <h4>✗ 錯誤選項原因</h4>
                        <ul>
                            <li><b>(A) <code>58</code>:</b> 未滿足最小寬度為 4 的要求。</li>
                            <li><b>(C) <code>  58</code>:</b> 這是 <code>%4d</code> 的輸出結果，用空格填充而非 <code>0</code>。</li>
                            <li><b>(D) <code>5800</code>:</b> 填充是在數字的左側（高位），而不是右側。</li>
                        </ul>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q3">下一題</button></div>
                </div>

                <div id="q3" class="quiz-card">
                    <h3>3. 考慮以下 `enum` 宣告，請問 `Right` 的值是多少？</h3>
                    <pre><code class="language-c">enum Direction { Up = 1, Down, Left, Right };</code></pre>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A"><code>0</code></div>
                        <div class="option" data-option="B"><code>2</code></div>
                        <div class="option" data-option="C"><code>3</code></div>
                        <div class="option" data-option="D"><code>4</code></div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 考點說明：`enum` (列舉) 的自動遞增值</h4>
                        <p>在 `enum` 中，如果某個成員沒有被明確賦值，它的值會是前一個成員的值加 1。</p>
                        <h4>✓ 逐行程式碼註釋</h4>
                        <pre><code class="language-c">// 宣告一個列舉型別 Direction
enum Direction {
    Up = 1,   // 'Up' 被明確賦值為 1
    Down,     // 'Down' 未賦值，其值為 Up + 1 = 2
    Left,     // 'Left' 未賦值，其值為 Down + 1 = 3
    Right     // 'Right' 未賦值，其值為 Left + 1 = 4
};</code></pre>
                        <p>因此，<code>Right</code> 的對應整數值為 4。</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q1">回到第一題</button></div>
                </div>
            </div>

        </main>

        <div class="resizer" id="dragMe"></div>

        <aside class="interactive-panel">
            <div class="interactive-panel-inner">
         

                <textarea id="code-editor" spellcheck="false" placeholder="點擊左側「運行示例」按鈕，或在此處編寫您的 C 程式碼..."></textarea>

                <div class="sandbox-controls">
                    <button id="run-code-btn" disabled>編譯與執行 (準備中...)</button>
                </div>

                <pre id="output-area" aria-live="polite">在此處查看程式輸出結果或編譯錯誤訊息...</pre>


            </div>
        </aside>

    </div>

    <script src="https://cdn.jsdelivr.net/gh/emscripten-core/emscripten/releases/emsdk-3.1.58/upstream/emscripten/src/embind/emcc-dev.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Code Samples for "Run Example" buttons ---
            const codeSamples = {
                'varDeclare': `#include <stdio.h>\n\nint main() {\n    int student_id = 101;\n    char grade = 'A';\n    float score = 95.5f;\n\n    printf("學號: %d\\n", student_id);\n    printf("等級: %c\\n", grade);\n    printf("分數: %.1f\\n", score);\n\n    return 0;\n}`,
                'sizeofOperator': `#include <stdio.h>\n\nint main() {\n    printf("一個 int 的大小: %zu bytes\\n", sizeof(int));\n    printf("一個 char 的大小: %zu bytes\\n", sizeof(char));\n    printf("一個 double 的大小: %zu bytes\\n", sizeof(double));\n\n    // %zu 是 C99 標準中用來印出 sizeof 結果的格式字元\n    return 0;\n}`,
                'constKeyword': `#include <stdio.h>\n\nint main() {\n    const double PI = 3.14159;\n    int radius = 10;\n    double area = PI * radius * radius;\n\n    printf("用 const 定義的 PI = %f\\n", PI);\n    printf("圓面積為: %f\\n", area);\n\n    // 嘗試修改 const 常數會導致編譯錯誤\n    // PI = 3.14; // <- 取消此行註解會報錯\n\n    return 0;\n}`,
                'defineDirective': `#include <stdio.h>\n\n#define MAX_USERS 100\n\nint main() {\n    printf("系統最大使用者數量為: %d\\n", MAX_USERS);\n\n    // 在編譯前，程式碼中的 MAX_USERS 會被直接替換成 100\n    return 0;\n}`,
                'enumType': `#include <stdio.h>\n\nenum Action { UP, DOWN, LEFT, RIGHT, STOP };\n\nint main() {\n    enum Action act = LEFT;\n    printf("預設情況下，LEFT 的值是: %d\\n", act); // 0, 1, 2 -> 輸出 2\n\n    act = STOP;\n    printf("STOP 的值是: %d\\n", act); // 3, 4 -> 輸出 4\n    return 0;\n}`,
                'printfExample': `#include <stdio.h>\n\nint main() {\n    int t = 25;\n    int rh = 72;\n    \n    printf("今天天氣很好\\n");\n    printf("溫度 %d 度\\n", t);\n    printf("溫度 %d 度，濕度 %d%%\\n", t, rh);\n    \n    return 0;\n}`,
                'printfFormatting': `#include <stdio.h>\n\nint main() {\n    printf("|%d|\\n", 7);\n    printf("|%3d|\\n", 7);\n    printf("|%03d|\\n", 7);\n    printf("|%d|\\n", 7000);\n    printf("|%.2f|\\n", 1.234);\n    printf("|%5.2f|\\n", 1.234);\n    return 0;\n}`,
                'scanfExample': `#include <stdio.h>\n\nint main() {\n    int age;\n\n    printf("請在下方執行結果區塊，輸入您的年齡並按 Enter: ");\n\n    // 注意：在網頁環境中，scanf 的互動方式可能與本機終端機不同。\n    // 這個沙箱模擬了輸入，但實際應用中可能需要其他方式處理網頁輸入。\n    scanf("%d", &age);\n\n    printf("\\n您輸入的年齡是: %d 歲\\n", age);\n    \n    return 0;\n}`
            };

            const codeEditor = document.getElementById('code-editor');
            const outputArea = document.getElementById('output-area');
            const runCodeBtn = document.getElementById('run-code-btn');

            let emscriptenModule = null;

            // Initialize Emscripten compiler
            Module.onRuntimeInitialized = () => {
                emscriptenModule = Module;
                runCodeBtn.disabled = false;
                runCodeBtn.textContent = '編譯與執行';
                outputArea.textContent = 'Emscripten 編譯器準備就緒。\n請載入範例或自行編寫程式碼。';
            };

            // Populate sandbox from "Run Example" buttons
            document.querySelectorAll('.run-example-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const codeId = button.getAttribute('data-code-id');
                    if (codeSamples[codeId]) {
                        codeEditor.value = codeSamples[codeId];
                        outputArea.textContent = '程式碼已載入。點擊「編譯與執行」來查看結果。';
                        codeEditor.focus();
                    }
                });
            });

            // Run Code Button Logic
            runCodeBtn.addEventListener('click', async () => {
                if (!emscriptenModule) {
                    outputArea.textContent = '錯誤：Emscripten 模組尚未初始化。';
                    return;
                }

                const code = codeEditor.value;
                outputArea.textContent = '編譯中，請稍候...\n';
                runCodeBtn.disabled = true;
                runCodeBtn.textContent = '編譯中...';

                try {
                    let stdout = '';
                    let stderr = '';

                    const options = {
                        noInitialRun: true,
                        print: (text) => { stdout += text + '\\n'; },
                        printErr: (text) => { stderr += text + '\\n'; }
                    };

                    // Compile C code to WASM
                    const result = emscriptenModule.ccall(
                        'emcc_compile', 'number', ['string', 'string'], [code, '-O2']
                    );

                    if (result === 0) {
                        outputArea.textContent = '編譯成功！準備執行...\n\n';

                        // Execute the compiled code
                        emscriptenModule.ccall('run_main', null, [], []);

                        // Display output
                        if(stderr) {
                           outputArea.textContent += `--- 標準錯誤 ---\n${stderr}\n`;
                        }
                        outputArea.textContent += `--- 程式輸出 ---\n${stdout}`;
                        outputArea.textContent += `\n--- 執行完畢 ---`;

                    } else {
                        outputArea.textContent = `--- 編譯失敗 ---\n${stderr}`;
                    }

                } catch (e) {
                    outputArea.textContent = `捕獲到未預期的錯誤：\n${e.message}\n${e.stack}`;
                } finally {
                    runCodeBtn.disabled = false;
                    runCodeBtn.textContent = '編譯與執行';
                }
            });

            // Quiz Logic
            document.querySelectorAll('.quiz-options').forEach(optionsContainer => {
                optionsContainer.addEventListener('click', function(e) {
                    if (e.target.classList.contains('option') && !this.classList.contains('answered')) {
                        const selectedOption = e.target;
                        const correctAnswer = this.getAttribute('data-correct');
                        const selectedAnswer = selectedOption.getAttribute('data-option');

                        this.classList.add('answered');

                        this.querySelectorAll('.option').forEach(opt => {
                           const optValue = opt.getAttribute('data-option');
                           let marker = '';
                           if(optValue === correctAnswer){
                               opt.classList.add('correct');
                               marker = ' ✅ 正確';
                           } else if (optValue === selectedAnswer) {
                               opt.classList.add('incorrect');
                               marker = ' ❌ 錯誤';
                           }
                           opt.innerHTML += marker;
                           opt.classList.add('answered');
                        });

                        const explanation = this.parentElement.querySelector('.explanation');
                        if (explanation) {
                            explanation.style.display = 'block';
                            Prism.highlightAllUnder(explanation); // Re-run Prism for explanation code blocks
                        }
                    }
                });
            });

            // Next Button Logic
            document.querySelectorAll('.next-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        const tutorialPanel = document.querySelector('.tutorial-content');
                        tutorialPanel.scrollTo({
                            top: targetElement.offsetTop - 30,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Resizer Logic
            const resizer = document.getElementById('dragMe');
            const leftSide = document.querySelector('.tutorial-content');
            const rightSide = document.querySelector('.interactive-panel');

            resizer.addEventListener('mousedown', function(e) {
                e.preventDefault();
                document.body.style.cursor = 'col-resize';

                const mouseMoveHandler = function(e) {
                    const containerRect = resizer.parentElement.getBoundingClientRect();
                    let newLeftWidth = e.clientX - containerRect.left;

                    if (newLeftWidth < 400) newLeftWidth = 400; // Min width for left
                    if (newLeftWidth > containerRect.width - 450) newLeftWidth = containerRect.width - 450; // Min width for right

                    leftSide.style.width = `${newLeftWidth}px`;
                    rightSide.style.width = `${containerRect.width - newLeftWidth}px`;
                };

                const mouseUpHandler = function() {
                    document.body.style.cursor = 'default';
                    document.removeEventListener('mousemove', mouseMoveHandler);
                    document.removeEventListener('mouseup', mouseUpHandler);
                };

                document.addEventListener('mousemove', mouseMoveHandler);
                document.addEventListener('mouseup', mouseUpHandler);
            });

            // Set initial code in editor
            codeEditor.value = `// 歡迎來到 C 語言互動教學！\n// 點擊左邊的「運行示例」按鈕來載入程式碼，\n// 或在此直接編寫。\n\n#include <stdio.h>\n\nint main() {\n    printf("Hello, World!\\n");\n    return 0;\n}\n`;
        });
    </script>

</body></html>
