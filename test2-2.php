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
        p, ul, ol { /* Added ol */
            font-size: 1em; /* Adjusted */
            line-height: 1.7; /* Added for readability */
            margin-bottom: 0.8em; /* Added */
        }
        ul, ol { /* Added ol */
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
            margin: 1em 0;
            padding: 10px; /* Added padding to pre */
            background-color: var(--code-bg); /* Added background to pre */
            border-radius: 4px; /* Added radius to pre */
            overflow-x: auto; /* Added for long code lines */
        }
        /* Explanation table styles */
        .explanation table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 15px;
            font-size: 0.9em;
            background-color: var(--code-bg); /* Table background */
        }
        .explanation th, .explanation td {
            border: 1px solid var(--border-color);
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }
        .explanation th {
            background-color: var(--primary-color); /* Header background */
            color: white;
            font-weight: bold;
        }
        .explanation td code {
             background-color: rgba(255,255,255,0.1);
             padding: 1px 4px;
             border-radius: 3px;
        }
        .explanation pre { /* Nested pre inside explanation */
            margin: 0.5em 0;
            padding: 8px;
            background-color: rgba(0,0,0,0.2); /* Slightly different for nested */
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
            margin-top: 5px;
            margin-bottom: 10px;
            font-size: 0.9em;
        }
        .run-example-btn:hover {
            background-color: #357ABD;
        }

        /* Interactive Panel Styles */
        .sandbox-container {
            background-color: var(--card-bg);
            border-radius: 8px;
            padding: 15px;
            border: 1px solid var(--border-color);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .interactive-panel-inner {
            display: flex;
            flex-direction: column;
            height: 100%;
            gap: 15px;
        }
        .sandbox-container h3 { /* Title for sandbox */
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
        /* Quiz Section Styles */
        .quiz-section {
            margin-top: 30px;
            background-color: transparent;
            border: none;
            padding: 0;
        }
        .quiz-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            scroll-margin-top: 20px;
        }
        .quiz-card h3 { /* Question title */
            margin-top: 0;
            color: var(--header-color);
            font-size: 1.2em;
            border-bottom: 1px dashed var(--border-color);
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .quiz-options .option {
            display: block;
            background-color: #3c3c3c;
            margin: 8px 0;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.3s, background-color 0.3s;
            position: relative;
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
            font-size: 1.1em;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 5px;
        }
        .explanation ul, .explanation ol { /* Added ol */
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
            <h1>C 語言入門：變數、常數與基本概念</h1>
            <p>歡迎來到 C 語言的互動學習之旅！本章節將帶您了解程式設計中最基本的元素：變數與常數。</p>

            <h2>2-3 基本輸入輸出 (變數篇)</h2>
            <p>程式執行時使用的資料，會暫時存在記憶體中，這些暫存的資料稱為<strong>變數 (Variable)</strong>。</p>

            <div class="knowledge-point">
                <h3>變數宣告</h3>
                <p>在使用變數前，必須先宣告變數，宣告的目的是定義變數的名稱與資料型態，以便編譯器能配置適當的記憶體空間。</p>
                <p><strong>宣告語法：</strong></p>
                <pre><code class="language-c">資料型態 變數名稱;</code></pre>
                <p><strong>宣告並給予初始值：</strong></p>
                <pre><code class="language-c">資料型態 變數名稱 = 初始值;</code></pre>
                <button class="run-example-btn" data-code-id="var-declare">運行示例</button>
            </div>

            <div class="knowledge-point">
                <h3>識別字 (Identifier) 命名規則</h3>
                <p>變數名稱必需是合法的<strong>識別字 (Identifier)</strong>，需符合下列規則：</p>
                <ul>
                    <li>(1) 可以使用英文字母 (a-z, A-Z)、阿拉伯數字 (0-9)，以及底線 `_`。不可以使用特殊字元 (如 @, #, %, &, *)。</li>
                    <li>(2) 不能使用阿拉伯數字開頭。例如 `1var` 是錯誤的。</li>
                    <li>(3) 英文的大小寫有區別。例如 `myVar` 和 `myvar` 是不同的變數。</li>
                    <li>(4) 不能使用 C 語言的關鍵字 (Keywords) 或保留字 (Reserved Word)，如 `int`, `for`, `while` 等。</li>
                </ul>
            </div>

            <div class="knowledge-point">
                <h3>多個變數宣告</h3>
                <p>若要在同一行程式敘述內，宣告多個相同資料型態的變數，需使用逗號 `,` 隔開。</p>
                <pre><code class="language-c">int score = 100, level = 5, players = 4;</code></pre>
                <button class="run-example-btn" data-code-id="multi-declare">運行示例</button>
            </div>

            <h2>2-4 變數與常數</h2>

            <div class="knowledge-point">
                <h3>sizeof 運算子</h3>
                <p>使用 `sizeof` 運算子，可以取得特定資料型態或變數所需的記憶體大小(單位為 byte)。</p>
                <pre><code class="language-c">double d = 3.14;
// sizeof(d) 的結果為 8，因為 double 型態佔 8 bytes
// sizeof(int) 的結果通常為 4
                </code></pre>
                <button class="run-example-btn" data-code-id="sizeof-op">運行示例</button>
            </div>

            <div class="knowledge-point">
                <h3>常數 (Constant)</h3>
                <p>常數的內容在定義後即固定，程式執行的過程中不可改變。宣告常數有以下幾種方式：</p>

                <h4>1. 使用 `const` 關鍵字</h4>
                <p>這是最現代且推薦的作法。它會建立一個具有特定型別的唯讀變數。</p>
                <pre><code class="language-c">const 資料型態 常數名稱 = 值;
// 範例
const double PI = 3.14159;</code></pre>
                <button class="run-example-btn" data-code-id="const-keyword">運行示例</button>

                <h4>2. 使用 `#define` 前置處理器</h4>
                <p>這是一種較舊的作法，它會在編譯前，將程式碼中所有出現的識別字直接替換成指定的標記字串。它不具備型別檢查。</p>
                <pre><code class="language-c">#define 識別字 標記字串
// 範例 (結尾不需要分號)
#define MAX_USERS 100</code></pre>
                <button class="run-example-btn" data-code-id="define-directive">運行示例</button>

                <h4>3. 使用 `enum` 列舉</h4>
                <p>使用列舉 (enumeration) 型態，可以建立一組有名稱的整數常數。</p>
                <pre><code class="language-c">enum 列舉名稱 { 列舉成員1, 列舉成員2, ... };</code></pre>
                <p>列舉成員會自動對應到一整數，若沒有指定，預設從 0 開始，依序遞增 1。</p>
                <pre><code class="language-c">enum Action { UP, DOWN, LEFT, RIGHT, STOP };
// UP = 0, DOWN = 1, LEFT = 2, ...

enum Color { RED = 1, BLUE, GREEN };
// RED = 1, BLUE = 2, GREEN = 3
                </code></pre>
                 <button class="run-example-btn" data-code-id="enum-type">運行示例</button>
            </div>

            <div class="quiz-section">
                <h2>2-5 程式設計實習 (互動題庫)</h2>
                <p>完成左側的學習後，試著挑戰下面的題目，檢驗你的學習成果！</p>

                <div id="q1" class="quiz-card">
                    <h3>1. 要在同一行程式碼中宣告多個整數變數，要使用哪一個符號間隔？</h3>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) `,`</div>
                        <div class="option" data-option="B">(B) `.`</div>
                        <div class="option" data-option="C">(C) `；` (全形分號)</div>
                        <div class="option" data-option="D">(D) `.`</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 考點說明：多變數宣告語法</h4><p>在 C 語言中，若要於單一敘述中宣告多個相同型別的變數，應使用半形的逗號 <code>,</code> 來分隔各個變數名稱。</p><pre><code class="language-c">// 正確語法
int a = 1, b = 2, c = 3;</code></pre>
                        <h4>✗ 錯誤選項原因</h4><ul><li><b>(B) . (句點):</b> 在 C 中主要用於存取 struct 或 union 的成員。</li><li><b>(C) ； (全形分號):</b> C 語言的語法符號皆為半形，全形字元會導致編譯錯誤。</li><li><b>(D) . (句號):</b> 同 (B)。</li></ul>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q2">下一題</button></div>
                </div>
                <div id="q2" class="quiz-card">
                    <h3>2. 下面哪一個是合法的變數名稱？</h3>
                    <div class="quiz-options" data-correct="D"><div class="option" data-option="A">(A) %123abc</div><div class="option" data-option="B">(B) &123abc</div><div class="option" data-option="C">(C) @123abc</div><div class="option" data-option="D">(D) _123abc</div></div>
                    <div class="explanation"><h4>✓ 考點說明：識別字命名規則</h4><p>C 語言的識別字 (包含變數名稱) 只能由英文字母、數字和底線 <code>_</code> 組成，且不能以數字開頭。底線 <code>_</code> 是唯一一個可以作為開頭的非英文字母字元。</p><h4>✗ 錯誤選項原因</h4><ul><li><b>(A) %123abc:</b> 包含特殊字元 <code>%</code>，不合法。</li><li><b>(B) &123abc:</b> 包含特殊字元 <code>&</code>，不合法。</li><li><b>(C) @123abc:</b> 包含特殊字元 <code>@</code>，不合法。</li></ul></div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q3">下一題</button></div>
                </div>
                <div id="q10" class="quiz-card">
                    <h3>10. 一程式片段如下，請問執行後的輸出為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;

void main() {
    enum color {Red=1, Blue, Yellow, Green, Black, White};
    color c = Yellow;
    printf("%d", c);
}
                    </code></pre>
                    <div class="quiz-options" data-correct="D"><div class="option" data-option="A">(A) 0</div><div class="option" data-option="B">(B) 1</div><div class="option" data-option="C">(C) 2</div><div class="option" data-option="D">(D) 3</div></div>
                    <div class="explanation"><h4>✓ 考點說明：`enum` (列舉) 的值分配</h4><p>在 `enum` 中，如果沒有為成員明確指定值，它會自動被設定為前一個成員的值加 1。如果第一個成員沒有指定值，則預設為 0。</p><h4>✓ 逐行程式碼註釋</h4><pre><code class="language-c">// 宣告一個名為 color 的列舉型別
// Red 被明確指定為 1
// Blue 未指定，所以其值為 Red + 1 = 2
// Yellow 未指定，所以其值為 Blue + 1 = 3
// Green = 4, Black = 5, White = 6
enum color {Red=1, Blue, Yellow, Green, Black, White};

// 宣告一個 color 型別的變數 c，並將其值設為 Yellow
// 此時 c 的內部整數值為 3
color c = Yellow;

// 使用 %d 格式化輸出整數，將 c 的值 (3) 印出
printf("%d", c);</code></pre><p>因此，程式會輸出 `3`。</p></div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q1">回到第一題</button></div>
                </div>

            </div>

        </main>

        <div class="resizer" id="dragMe"></div>

        <aside class="interactive-panel">
            <div class="interactive-panel-inner">
                <div class="sandbox-container">

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
                'var-declare': `#include <stdio.h>\n\nint main() {\n    int age = 25;\n    char grade = 'A';\n\n    printf("年齡: %d\\n", age);\n    printf("等級: %c\\n", grade);\n\n    return 0;\n}`,
                'multi-declare': `#include <stdio.h>\n\nint main() {\n    double price = 99.9, weight = 5.2, tax = 0.05;\n\n    printf("價格: %.2f\\n", price);\n    printf("重量: %.1f\\n", weight);\n    printf("稅率: %.2f\\n", tax);\n\n    return 0;\n}`,
                'sizeof-op': `#include <stdio.h>\n\nint main() {\n    printf("int 的大小: %zu bytes\\n", sizeof(int));\n    printf("double 的大小: %zu bytes\\n", sizeof(double));\n    printf("char 的大小: %zu bytes\\n", sizeof(char));\n\n    return 0;\n}`,
                'const-keyword': `#include <stdio.h>\n\nint main() {\n    const int MAX_ATTEMPTS = 3;\n    printf("最大嘗試次數為: %d\\n", MAX_ATTEMPTS);\n    return 0;\n}`,
                'define-directive': `#include <stdio.h>\n\n#define PI 3.14159\n\nint main() {\n    double radius = 10.0;\n    double area = PI * radius * radius;\n    printf("半徑為 %.1f 的圓面積為: %f\\n", radius, area);\n    return 0;\n}`,
                'enum-type': `#include <stdio.h>\n\nenum Action { UP, DOWN, LEFT, RIGHT, STOP };\n\nint main() {\n    enum Action act = UP;\n    printf("act 的值是 (UP): %d\\n", act);\n    act = STOP;\n    printf("act 的值是 (STOP): %d\\n", act);\n    return 0;\n}`
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
            codeEditor.value = codeSamples['var-declare'];
        });
    </script>
</body>
</html>
=======
            <div class="quiz-section">
                <h2>第二章 互動練習題 - 詳細解說版</h2>
                <p>請挑戰下面的題目，檢驗您的學習成果！點擊選項後會顯示包含詳細追蹤過程的詳解。</p>
                <!-- QUIZ CARDS START -->
                <div id="q1" class="quiz-card">
                    <h3>1. 有關 c++語言中變數命名，下列那一個錯誤？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) Void</div>
                        <div class="option" data-option="B">(B) _123</div>
                        <div class="option" data-option="C">(C) print</div>
                        <div class="option" data-option="D">(D) int</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C/C++ 變數命名規則與關鍵字</h4>
                        <p>在 C/C++ 中，變數（或更廣泛地說，識別字）的命名規則如下：</p>
                        <ul>
                            <li>可以包含英文字母 (a-z, A-Z)、數字 (0-9) 和底線 (<code>_</code>)。</li>
                            <li>第一個字元不能是數字。</li>
                            <li>區分大小寫 (例如，<code>myVar</code> 和 <code>MyVar</code> 是不同的)。</li>
                            <li>不能是語言的關鍵字 (Reserved Words)。</li>
                        </ul>
                        <p>分析選項：</p>
                        <ul>
                            <li><b>(A) Void:</b> <code>Void</code> (大寫 V) 不是 C/C++ 的關鍵字 (關鍵字是全小寫的 <code>void</code>)。因此，<code>Void</code> 是一個合法的變數名稱。</li>
                            <li><b>(B) _123:</b> 以底線開頭，後續為數字，這是合法的變數名稱。</li>
                            <li><b>(C) print:</b> <code>print</code> 不是 C/C++ 的關鍵字 (標準庫中有 <code>printf</code> 函數，但 <code>print</code> 本身不是保留字)。因此，<code>print</code> 是一個合法的變數名稱（儘管不建議這樣命名以避免與可能的函數名混淆）。</li>
                            <li><b>(D) int:</b> <code>int</code> 是 C/C++ 中用於宣告整數型別的關鍵字。關鍵字不能被用作變數名稱。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q2">下一題</button></div>
                </div>

                <div id="q2" class="quiz-card">
                    <h3>2. 有關 c++語言的變數命名，以下何者正確？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) %abcd</div>
                        <div class="option" data-option="B">(B) 1abcd</div>
                        <div class="option" data-option="C">(C) fruit-apple_long_name</div>
                        <div class="option" data-option="D">(D) _a_long_name</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C/C++ 變數命名規則</h4>
                        <p>再次回顧 C/C++ 變數命名規則：</p>
                        <ul>
                            <li>可包含字母、數字、底線。</li>
                            <li>不可數字開頭。</li>
                            <li>不可為關鍵字。</li>
                            <li>不可包含特殊字元如 <code>%</code>, <code>-</code> 等。</li>
                        </ul>
                        <p>分析選項：</p>
                        <ul>
                            <li><b>(A) %abcd:</b> 包含特殊字元 <code>%</code>，不合法。</li>
                            <li><b>(B) 1abcd:</b> 以數字 <code>1</code> 開頭，不合法。</li>
                            <li><b>(C) fruit-apple_long_name:</b> 包含特殊字元 <code>-</code> (減號)，不合法。合法的標識符中不能使用連字符。</li>
                            <li><b>(D) _a_long_name:</b> 以底線開頭，後續為字母和底線，完全符合命名規則，合法。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q3">下一題</button></div>
                </div>

                <div id="q3" class="quiz-card">
                    <h3>3. 以下何者不是 c++語言整數資料型態？</h3>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) double</div>
                        <div class="option" data-option="B">(B) short</div>
                        <div class="option" data-option="C">(C) byte</div>
                        <div class="option" data-option="D">(D) int</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C/C++ 資料型態</h4>
                        <p>C/C++ 標準的整數資料型態主要包括：</p>
                        <ul>
                            <li><code>char</code> (技術上是整數型別，常來儲存字元)</li>
                            <li><code>short int</code> (或簡寫為 <code>short</code>)</li>
                            <li><code>int</code></li>
                            <li><code>long int</code> (或簡寫為 <code>long</code>)</li>
                            <li><code>long long int</code> (或簡寫為 <code>long long</code>)</li>
                        </ul>
                        <p>這些都可以配合 <code>signed</code> (預設) 或 <code>unsigned</code> 修飾。</p>
                        <p>分析選項：</p>
                        <ul>
                            <li><b>(A) double:</b> 這是浮點數資料型態，用於儲存帶有小數的數值，不是整數型態。</li>
                            <li><b>(B) short:</b> 是 <code>short int</code> 的簡寫，為整數資料型態。</li>
                            <li><b>(C) byte:</b> <code>byte</code> 不是 C++ 標準的關鍵字或基本資料型態。雖然一個位元組 (byte) 是記憶體的基本單位，且 <code>char</code> 通常佔用一個位元組，但 <code>byte</code> 本身並非型別關鍵字。然而，題目問「不是整數資料型態」，而 <code>double</code> 明顯不是。如果題目是在比較標準型態，<code>byte</code> 不是標準型態，但 <code>double</code> 更明確地「不是整數型態」。</li>
                            <li><b>(D) int:</b> 標準的整數資料型態。</li>
                        </ul>
                        <p>在選項中，<code>double</code> 是唯一明確的非整數資料型態。而 <code>byte</code> 不是標準 C++ 資料型態，但題目問的是「不是整數資料型態」。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q4">下一題</button></div>
                </div>

                <div id="q4" class="quiz-card">
                    <h3>4. 若考慮正負號，1 個 Byte 的長度，它可以儲存的最大值</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 255</div>
                        <div class="option" data-option="B">(B) 127</div>
                        <div class="option" data-option="C">(C) 512</div>
                        <div class="option" data-option="D">(D) 36727</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：有符號整數範圍</h4>
                        <p>1 個 Byte 等於 8 個位元 (bits)。</p>
                        <p>當考慮正負號時 (即有符號數)，通常使用一個位元來表示符號 (0 代表正，1 代表負)。剩下的 7 個位元用於表示數值的大小。</p>
                        <p>對於一個 n 位元的有符號整數，其表示範圍通常是：</p>
                        <p><code>-2<sup>(n-1)</sup></code> 到 <code>2<sup>(n-1)</sup> - 1</code></p>
                        <p>在此題中，n = 8 (因為 1 Byte = 8 bits)。</p>
                        <ul>
                            <li>最小值：<code>-2<sup>(8-1)</sup> = -2<sup>7</sup> = -128</code></li>
                            <li>最大值：<code>2<sup>(8-1)</sup> - 1 = 2<sup>7</sup> - 1 = 128 - 1 = 127</code></li>
                        </ul>
                        <p>所以，1 個 Byte 長度的有符號整數可以儲存的最大值是 127。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q5">下一題</button></div>
                </div>

                <div id="q5" class="quiz-card">
                    <h3>5. 若不考慮正負號，1 個 Byte 的長度，它可以儲存的最大值？</h3>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 255</div>
                        <div class="option" data-option="B">(B) 512</div>
                        <div class="option" data-option="C">(C) 128</div>
                        <div class="option" data-option="D">(D) 1024</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：無符號整數範圍</h4>
                        <p>1 個 Byte 等於 8 個位元 (bits)。</p>
                        <p>當不考慮正負號時 (即無符號數)，所有的位元都用於表示數值的大小。</p>
                        <p>對於一個 n 位元的無符號整數，其表示範圍是：</p>
                        <p><code>0</code> 到 <code>2<sup>n</sup> - 1</code></p>
                        <p>在此題中，n = 8。</p>
                        <ul>
                            <li>最小值：<code>0</code></li>
                            <li>最大值：<code>2<sup>8</sup> - 1 = 256 - 1 = 255</code></li>
                        </ul>
                        <p>所以，1 個 Byte 長度的無符號整數可以儲存的最大值是 255。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q6">下一題</button></div>
                </div>

                <div id="q6" class="quiz-card">
                    <h3>6. c++程式指令 printf("%6.2f", 597.7231); 執行後輸出為以下那一個？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main() {
  printf("%6.2f", 597.7231);
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q6-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 597.723</div>
                        <div class="option" data-option="B">(B) 597.72</div>
                        <div class="option" data-option="C">(C) 000597.72</div>
                        <div class="option" data-option="D">(D) 597</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：<code>printf</code> 格式化輸出</h4>
                        <p>格式指定字 <code>%6.2f</code> 用於輸出浮點數，其含義如下：</p>
                        <ul>
                            <li><code>f</code>：表示以浮點數形式輸出。</li>
                            <li><code>.2</code>：表示小數點後保留 2 位。原始數字 <code>597.7231</code> 會被四捨五入 (或截斷，取決於實現，但通常是四捨五入) 到小數點後兩位，即 <code>597.72</code>。</li>
                            <li><code>6</code>：表示輸出的總寬度至少為 6 個字元。如果實際輸出的字元數少於 6，則會在左邊用空格填充以達到總寬度。</li>
                        </ul>
                        <p>執行步驟：</p>
                        <ol>
                            <li>數值 <code>597.7231</code> 根據 <code>.2f</code> 格式化為 <code>597.72</code>。</li>
                            <li>字串 "597.72" 的長度是 6 個字元 (5, 9, 7, ., 7, 2)。</li>
                            <li>由於指定的總寬度 <code>6</code> 等於實際字串長度 <code>6</code>，所以不需要額外填充空格。</li>
                        </ol>
                        <p>因此，輸出結果為 "597.72"。</p>
                        <p>分析錯誤選項：</p>
                        <ul>
                            <li>(A) 597.723: 小數點後位數不對，應為2位。</li>
                            <li>(C) 000597.72: <code>%6.2f</code> 預設以空格填充，若要以0填充需用 <code>%06.2f</code>。</li>
                            <li>(D) 597: 這是整數部分，忽略了小數。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q7">下一題</button></div>
                </div>

                <div id="q7" class="quiz-card">
                    <h3>7. 程式執行時，程式中的變數值是存放在</h3>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 記憶體</div>
                        <div class="option" data-option="B">(B) 硬碟</div>
                        <div class="option" data-option="C">(C) 輸出入裝置</div>
                        <div class="option" data-option="D">(D) 匯流排</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：變數儲存位置</h4>
                        <p>當一個程式執行時，其指令和資料（包括變數的值）主要被載入到電腦的**記憶體 (Memory / RAM - Random Access Memory)** 中。CPU 從記憶體中讀取指令並執行，同時也在記憶體中讀取和寫入變數的值。</p>
                        <ul>
                            <li><b>(A) 記憶體：</b>正確。RAM 是程式執行時變數的主要儲存區域。</li>
                            <li><b>(B) 硬碟：</b>硬碟是永久性儲存裝置，用於儲存程式檔案本身和作業系統等。程式執行前，程式碼和部分初始資料可能儲存在硬碟上，但執行時會被載入到記憶體。執行過程中頻繁變動的變數值不會直接寫回硬碟（除非有特定檔案I/O操作）。</li>
                            <li><b>(C) 輸出入裝置：</b>如鍵盤、螢幕、印表機等，用於與使用者或外部世界互動，不是儲存變數值的地方。</li>
                            <li><b>(D) 匯流排：</b>匯流排 (Bus) 是電腦內部組件之間傳輸資料和指令的通道，例如 CPU 和記憶體之間的資料傳輸。它本身不儲存變數值，而是傳輸它們。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q8">下一題</button></div>
                </div>

                <div id="q8" class="quiz-card">
                    <h3>8. 如果 x=123 則使用敘述 printf("%6d",x); 顯示 x 時</h3>
                     <pre><code class="language-c">#include &lt;stdio.h&gt;
int main() {
  int x = 123;
  printf("'%6d'", x); // Added quotes to visualize spaces
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q8-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 總共 6 個位置，  格在後</div>
                        <div class="option" data-option="B">(B) 總共 6 個位置，  格在前</div>
                        <div class="option" data-option="C">(C) 自動調整為 3 個位置</div>
                        <div class="option" data-option="D">(D) 以上皆非</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：<code>printf</code> 格式化輸出 (整數寬度與對齊)</h4>
                        <p>格式指定字 <code>%6d</code> 用於輸出整數，其含義如下：</p>
                        <ul>
                            <li><code>d</code>：表示以十進位整數形式輸出。</li>
                            <li><code>6</code>：表示輸出的總寬度至少為 6 個字元。</li>
                        </ul>
                        <p>執行步驟：</p>
                        <ol>
                            <li>要輸出的整數 <code>x</code> 是 123。</li>
                            <li>字串 "123" 的長度是 3 個字元。</li>
                            <li>指定的總寬度是 6 個字元。由於實際字元數 (3) 小於指定寬度 (6)，<code>printf</code> 預設會進行右對齊 (right-justification)，並在數字的左邊用空格填充以達到總寬度。</li>
                            <li>需要填充的空格數 = 總寬度 - 數字長度 = 6 - 3 = 3 個空格。</li>
                        </ol>
                        <p>因此，輸出結果將是 "   123" (前面有三個空格)，總共佔用 6 個位置，空格在前。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q9">下一題</button></div>
                </div>

                <div id="q9" class="quiz-card">
                    <h3>9. 在 c 語言中，資料型別 short 代表用較少的 bytes 數來記錄整數。相較於 int，short 只需要 2 bytes，請問 short 能記錄的最大數及最小數分別為多少？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 32767，0</div>
                        <div class="option" data-option="B">(B) 32768，-32768</div>
                        <div class="option" data-option="C">(C) 32767，-32768</div>
                        <div class="option" data-option="D">(D) 32768，0</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：<code>short int</code> 型別範圍</h4>
                        <p>題目指出 <code>short</code> (即 <code>short int</code>) 占用 2 bytes。</p>
                        <p>2 bytes = 2 * 8 bits = 16 bits。</p>
                        <p><code>short</code> 預設是有符號的 (<code>signed short int</code>)。對於一個 n 位元的有符號整數，其表示範圍是：</p>
                        <p><code>-2<sup>(n-1)</sup></code> 到 <code>2<sup>(n-1)</sup> - 1</code></p>
                        <p>在此題中，n = 16。</p>
                        <ul>
                            <li>最小值：<code>-2<sup>(16-1)</sup> = -2<sup>15</sup> = -32768</code></li>
                            <li>最大值：<code>2<sup>(16-1)</sup> - 1 = 2<sup>15</sup> - 1 = 32768 - 1 = 32767</code></li>
                        </ul>
                        <p>所以，<code>short</code> 能記錄的最大數是 32767，最小數是 -32768。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q10">下一題</button></div>
                </div>

                <div id="q10" class="quiz-card">
                    <h3>10. 下列 4 種數值資料型別，何者可表示的數值資料範圍最大？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 整數(Integer)</div>
                        <div class="option" data-option="B">(B) 長整數(Long)</div>
                        <div class="option" data-option="C">(C) 單精度(Single)</div>
                        <div class="option" data-option="D">(D) 倍精度(Double)</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：比較數值資料型別的範圍</h4>
                        <p>我們需要比較這些型別通常的表示範圍：</p>
                        <ul>
                            <li><b>(A) 整數 (Integer / <code>int</code>):</b> 通常是 4 bytes (32 bits)。
                                <ul><li>有符號範圍約：-2 × 10<sup>9</sup> 到 +2 × 10<sup>9</sup>。</li></ul>
                            </li>
                            <li><b>(B) 長整數 (Long / <code>long int</code>):</b> 至少與 <code>int</code> 一樣大，通常是 4 bytes 或 8 bytes (64 bits)。
                                <ul>
                                    <li>4 bytes: 範圍同 <code>int</code>。</li>
                                    <li>8 bytes: 範圍約：-9 × 10<sup>18</sup> 到 +9 × 10<sup>18</sup>。</li>
                                </ul>
                            </li>
                            <li><b>(C) 單精度 (Single / <code>float</code>):</b> 通常是 4 bytes (32 bits)，遵循 IEEE 754 標準。
                                <ul><li>大約可表示 ±3.4 × 10<sup>38</sup>，但有效數字約 6-7 位。</li></ul>
                            </li>
                            <li><b>(D) 倍精度 (Double / <code>double</code>):</b> 通常是 8 bytes (64 bits)，遵循 IEEE 754 標準。
                                <ul><li>大約可表示 ±1.7 × 10<sup>308</sup>，有效數字約 15-16 位。</li></ul>
                            </li>
                        </ul>
                        <p>比較這些範圍：</p>
                        <p>浮點數 (<code>float</code>, <code>double</code>) 可以表示的數值絕對大小遠大於整數型別 (<code>int</code>, <code>long</code>)，因為它們使用科學記號法的方式來儲存數字（一個符號位、若干指數位、若干尾數位）。</p>
                        <p>在 <code>float</code> 和 <code>double</code> 之間，<code>double</code> 使用更多的位元 (通常 64 bits vs 32 bits for <code>float</code>)，因此它可以表示更大範圍的數值，並且具有更高的精度。</p>
                        <p>所以，<code>double</code> (倍精度) 可表示的數值資料範圍最大。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q11">下一題</button></div>
                </div>

                <div id="q11" class="quiz-card">
                    <h3>11. 在撰寫 c 語言程式時，下列哪一個變數宣告可以儲存 64 位元的浮點數？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) int</div>
                        <div class="option" data-option="B">(B) float</div>
                        <div class="option" data-option="C">(C) long</div>
                        <div class="option" data-option="D">(D) double</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C 語言資料型別大小</h4>
                        <p>在 C 語言中，不同資料型態佔用的記憶體大小（位元數）通常如下 (常見實現)：</p>
                        <ul>
                            <li><b><code>int</code>:</b> 通常是 32 位元 (4 bytes)，用於儲存整數。</li>
                            <li><b><code>float</code>:</b> 通常是 32 位元 (4 bytes)，用於儲存單精度浮點數。</li>
                            <li><b><code>long</code> (或 <code>long int</code>):</b> 通常是 32 位元 (4 bytes) 或 64 位元 (8 bytes)，用於儲存整數。其大小至少不小於 <code>int</code>。</li>
                            <li><b><code>double</code>:</b> 通常是 64 位元 (8 bytes)，用於儲存雙精度浮點數。</li>
                        </ul>
                        <p>題目要求儲存 64 位元的「浮點數」。根據上述，<code>double</code> 是標準的 64 位元浮點數型別。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q12">下一題</button></div>
                </div>

                <div id="q12" class="quiz-card">
                    <h3>12. 若我們以 c++撰寫程式碼 std::cout &lt;&lt;"2016 holidays";，請問其中的 cout 是？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 運算子</div>
                        <div class="option" data-option="B">(B) 類別</div>
                        <div class="option" data-option="C">(C) 物件</div>
                        <div class="option" data-option="D">(D) 變數</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C++ I/O Streams</h4>
                        <p>在 C++ 中，<code>std::cout</code> 是標準輸出流 (standard output stream) 的一個實例 (instance)。</p>
                        <ul>
                            <li><b>運算子 (Operator):</b> 在此敘述中，<code>&lt;&lt;</code> 是運算子，稱為插入運算子 (insertion operator) 或流插入運算子，用於將資料插入到輸出流中。</li>
                            <li><b>類別 (Class):</b> <code>cout</code> 是 <code>std::ostream</code> 類別的一個實例。<code>ostream</code> 是一個定義了輸出流操作的類別。</li>
                            <li><b>物件 (Object):</b> <code>std::cout</code> 是一個預先定義好的全域物件 (global object)。物件是類別的實例。因為 <code>cout</code> 是 <code>ostream</code> 類別的一個具體實例，所以它是一個物件。</li>
                            <li><b>變數 (Variable):</b> 雖然物件在記憶體中佔有空間並且有其狀態，就像變數一樣，但在物件導向的術語中，<code>cout</code> 更精確地被描述為一個物件。它不是一個由程式設計師隨意宣告和改變其指向的簡單變數。</li>
                        </ul>
                        <p>因此，<code>cout</code> 最準確的描述是一個物件。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q13">下一題</button></div>
                </div>

                <div id="q13" class="quiz-card">
                    <h3>13. 使用函數 printf( )輸出字元時必須使用以下哪一種格式？</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) %s</div>
                        <div class="option" data-option="B">(B) %c</div>
                        <div class="option" data-option="C">(C) %d</div>
                        <div class="option" data-option="D">(D) %f</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：<code>printf</code> 格式指定字</h4>
                        <p><code>printf</code> 函數使用格式指定字 (format specifiers) 來決定如何解釋和輸出其後的參數：</p>
                        <ul>
                            <li><b><code>%s</code>:</b> 用於輸出一串字元，即字串 (string)。對應的參數應該是一個指向字元陣列 (字串) 的指標 (<code>char*</code>)。</li>
                            <li><b><code>%c</code>:</b> 用於輸出單一個字元 (character)。對應的參數應該是一個 <code>char</code> 型別的值 (或可以被提升為 <code>int</code> 的字元值)。</li>
                            <li><b><code>%d</code> (或 <code>%i</code>):</b> 用於輸出帶正負號的十進位整數 (signed decimal integer)。</li>
                            <li><b><code>%f</code>:</b> 用於輸出浮點數 (floating-point number) 並以十進位表示法顯示 (例如 <code>123.456</code>)。</li>
                        </ul>
                        <p>題目問的是輸出「字元」，因此應使用 <code>%c</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q14">下一題</button></div>
                </div>

                <div id="q14" class="quiz-card">
                    <h3>14. 若 a 為一浮點數，a=3.1415; printf("%.2f", a);會印出？</h3>
                     <pre><code class="language-c">#include &lt;stdio.h&gt;
int main() {
  float a = 3.1415f; // Use 'f' suffix for float literals
  printf("%.2f", a);
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q14-code">運行示例</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 3.141</div>
                        <div class="option" data-option="B">(B) 3.14</div>
                        <div class="option" data-option="C">(C) 3.1</div>
                        <div class="option" data-option="D">(D) 3.2</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：<code>printf</code> 浮點數精度控制</h4>
                        <p>格式指定字 <code>%.2f</code> 用於輸出浮點數：</p>
                        <ul>
                            <li><code>f</code>：表示以浮點數形式輸出。</li>
                            <li><code>.2</code>：表示指定小數點後輸出 2 位數字。如果原始數字小數部分多於 2 位，則會進行四捨五入 (或截斷，但通常是四捨五入到最接近的值)。</li>
                        </ul>
                        <p>執行步驟：</p>
                        <ol>
                            <li>變數 <code>a</code> 的值是 <code>3.1415</code>。</li>
                            <li>根據 <code>.2f</code>，需要將 <code>3.1415</code> 格式化到小數點後兩位。</li>
                            <li>第三位小數是 1，小於 5，所以第二位小數 4 不進位。</li>
                            <li>結果為 <code>3.14</code>。</li>
                        </ol>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q15">下一題</button></div>
                </div>

                <div id="q15" class="quiz-card">
                    <h3>15. c++語言提供 int、short、long、char、float、double 等幾種基本資料型態，關於其所需的記憶體空間大小的排序，下列何者正確？</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) short=char&lt;int&lt;float&lt;double=long</div>
                        <div class="option" data-option="B">(B) char&lt;short&lt;int=float=long&lt;double</div>
                        <div class="option" data-option="C">(C) char&lt;short&lt;int=float&lt;double&lt;long</div>
                        <div class="option" data-option="D">(D) short&lt;char=int=float&lt;long&lt;double</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C/C++ 基本資料型態大小</h4>
                        <p>C++ 標準規定了各種資料型態的最小大小關係，但具體大小可能因平台和編譯器而異。以下是常見的典型大小 (以 bytes 為單位)：</p>
                        <ul>
                            <li><code>char</code>: 1 byte</li>
                            <li><code>short</code> (<code>short int</code>): 2 bytes</li>
                            <li><code>int</code>: 通常 4 bytes (但標準只保證至少與 <code>short</code> 一樣大)</li>
                            <li><code>long</code> (<code>long int</code>): 通常 4 bytes (在 32 位系統) 或 8 bytes (在 64 位系統)。標準保證至少與 <code>int</code> 一樣大。</li>
                            <li><code>long long</code> (<code>long long int</code>): 通常 8 bytes (C++11 及之後標準)。</li>
                            <li><code>float</code>: 4 bytes (單精度浮點數)</li>
                            <li><code>double</code>: 8 bytes (雙精度浮點數)</li>
                        </ul>
                        <p>根據 C++ 標準，我們有以下保證的大小關係：</p>
                        <p><code>sizeof(char) &lt;= sizeof(short) &lt;= sizeof(int) &lt;= sizeof(long) &lt;= sizeof(long long)</code></p>
                        <p>且 <code>sizeof(float) &lt;= sizeof(double) &lt;= sizeof(long double)</code>。</p>
                        <p>考慮選項中給出的型態和常見大小：</p>
                        <ul>
                            <li><code>char</code>: 1 byte</li>
                            <li><code>short</code>: 2 bytes</li>
                            <li><code>int</code>: 4 bytes</li>
                            <li><code>float</code>: 4 bytes</li>
                            <li><code>long</code>: 4 bytes (在許多常見系統上，與 <code>int</code> 相同) 或 8 bytes</li>
                            <li><code>double</code>: 8 bytes</li>
                        </ul>
                        <p>分析選項：</p>
                        <ul>
                            <li><b>(A) short=char... :</b> 錯誤，<code>short</code> (2) 通常不等於 <code>char</code> (1)。</li>
                            <li><b>(B) char &lt; short &lt; int = float = long &lt; double:</b>
                                <ul>
                                    <li><code>char</code> (1) &lt; <code>short</code> (2): 正確</li>
                                    <li><code>short</code> (2) &lt; <code>int</code> (4): 正確</li>
                                    <li><code>int</code> (4) = <code>float</code> (4): 正確 (常見情況)</li>
                                    <li><code>float</code> (4) = <code>long</code> (4, 在某些32位系統或特定編譯器設定下): 可能正確</li>
                                    <li><code>long</code> (4 or 8) &lt; <code>double</code> (8): 如果 <code>long</code> 是 4 bytes，則 4 &lt; 8 正確。如果 <code>long</code> 是 8 bytes，則 8 = 8 也符合小於等於。</li>
                                    <li>此選項在 <code>long</code> 為 4 bytes 的情況下是最符合的常見排序。</li>
                                </ul>
                            </li>
                            <li><b>(C) ...double &lt; long:</b> 錯誤，<code>double</code> (8) 通常不小於 <code>long</code> (4 或 8)。</li>
                            <li><b>(D) short &lt; char...:</b> 錯誤，<code>short</code> (2) 通常不小於 <code>char</code> (1)。</li>
                        </ul>
                        <p>考慮到 <code>long</code> 在很多系統上（尤其是舊的或32位系統）是4位元組，選項 (B) 是最接近普遍情況的描述。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q16">下一題</button></div>
                </div>

                <div id="q16" class="quiz-card">
                    <h3>16. 關於 c 語言中的基本資料型態，其所佔用的記憶體空間大小，何者有誤？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) int：32bit</div>
                        <div class="option" data-option="B">(B) char：8bit</div>
                        <div class="option" data-option="C">(C) long：64bit</div>
                        <div class="option" data-option="D">(D) double：64bit</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C 語言資料型態大小</h4>
                        <p>C 語言標準並未嚴格規定各資料型態的確切位元數，而是規定了它們之間的相對大小關係和最小範圍。但以下是常見的、在多數現代系統上的典型大小：</p>
                        <ul>
                            <li><b><code>int</code>:</b> 通常是 32 位元 (4 bytes)。這是普遍的實現。</li>
                            <li><b><code>char</code>:</b> 幾乎總是 8 位元 (1 byte)，足以儲存執行字集中的一個字元。</li>
                            <li><b><code>long</code> (或 <code>long int</code>):</b> 其大小至少與 <code>int</code> 相同。在許多 32 位元系統上，<code>long</code> 是 32 位元。在 64 位元系統上，<code>long</code> 通常是 64 位元。因此，說 <code>long</code> 固定是 64bit 可能不完全準確，但說它「有誤」則要看上下文。然而，如果 <code>int</code> 是 32bit，則 <code>long</code> 至少也是 32bit。</li>
                            <li><b><code>double</code>:</b> 通常是 64 位元 (8 bytes)，用於雙精度浮點數。</li>
                        </ul>
                        <p>分析選項：</p>
                        <ul>
                            <li><b>(A) int：32bit:</b> 這是非常常見且普遍接受的大小。</li>
                            <li><b>(B) char：8bit:</b> 這是標準且普遍的大小。</li>
                            <li><b>(C) long：64bit:</b> 在 64 位元系統上是常見的，但在 32 位元系統上 <code>long</code> 通常是 32 位元。如果題目是基於「所有情況」或「最小保證」，則此說法可能不總是成立。如果題目基於一個 <code>int</code> 為 32 位元的常見環境，而 <code>long</code> 也是 32 位元，那麼宣稱 <code>long</code> 是 64bit 就是錯誤的。</li>
                            <li><b>(D) double：64bit:</b> 這是標準的 IEEE 754 雙精度大小。</li>
                        </ul>
                        <p>考慮到 "有誤" 這個詞，選項 (C) 的陳述 "long：64bit" 是最可能錯誤的，因為 <code>long</code> 並不保證在所有 C 環境中都是 64 位元。例如，在許多 LLP64 模型 (Windows 64位元) 中，<code>long</code> 仍然是 32 位元，而 <code>long long</code> 才是 64 位元。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q17">下一題</button></div>
                </div>

                <div id="q17" class="quiz-card">
                    <h3>17. 使用 c 語言的輸出函數 printf( )，要輸出浮點數時，必須使用下列那一種格式控制字元？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) %i</div>
                        <div class="option" data-option="B">(B) %c</div>
                        <div class="option" data-option="C">(C) %f</div>
                        <div class="option" data-option="D">(D) %o</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：<code>printf</code> 格式指定字</h4>
                        <p><code>printf</code> 函數使用格式指定字來決定如何解釋和輸出其後的參數：</p>
                        <ul>
                            <li><b><code>%i</code> (或 <code>%d</code>):</b> 用於輸出帶正負號的十進位整數 (signed decimal integer)。</li>
                            <li><b><code>%c</code>:</b> 用於輸出單一個字元 (character)。</li>
                            <li><b><code>%f</code>:</b> 用於輸出浮點數 (<code>float</code> 或 <code>double</code> - <code>float</code> 會被提升為 <code>double</code> 傳遞給 <code>printf</code>) 並以十進位表示法顯示 (例如 <code>123.456</code>)。</li>
                            <li><b><code>%e</code> 或 <code>%E</code>:</b> 用於以科學記號法輸出浮點數 (例如 <code>1.23456e+02</code>)。</li>
                            <li><b><code>%g</code> 或 <code>%G</code>:</b> 根據數值的大小自動選擇 <code>%f</code> 或 <code>%e</code> (<code>%E</code>) 中較短的表示。</li>
                            <li><b><code>%o</code>:</b> 用於輸出無符號八進位整數 (unsigned octal integer)。</li>
                        </ul>
                        <p>題目問的是輸出「浮點數」，因此應使用 <code>%f</code> (或其他浮點數格式如 <code>%e</code>, <code>%g</code>，但 <code>%f</code> 是最直接的)。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q18">下一題</button></div>
                </div>

                <div id="q18" class="quiz-card">
                    <h3>18. 一 c 語言程式指令 printf("%c",66);執行後的輸出為何？</h3>
                    <pre><code class="language-c">#include &lt;stdio.h&gt;
int main() {
  printf("%c", 66);
  return 0;
}</code></pre>
                    <button class="run-example-btn" data-code-id="q18-code">運行示例</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 66</div>
                        <div class="option" data-option="B">(B) c</div>
                        <div class="option" data-option="C">(C) B</div>
                        <div class="option" data-option="D">(D) 42</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：<code>printf</code> 字元輸出與 ASCII</h4>
                        <p>指令 <code>printf("%c", 66);</code> 的含義是：</p>
                        <ul>
                            <li><code>%c</code>：這是一個格式指定字，告訴 <code>printf</code> 將對應的參數解釋為一個字元並輸出該字元。</li>
                            <li><code>66</code>：這是傳遞給 <code>%c</code> 的參數。當 <code>%c</code> 接收一個整數時，它會將該整數視為一個 ASCII (或系統使用的字元集) 碼。</li>
                        </ul>
                        <p>在 ASCII 編碼中：</p>
                        <ul>
                            <li>十進位數值 65 對應大寫字母 'A'。</li>
                            <li>十進位數值 66 對應大寫字母 'B'。</li>
                            <li>十進位數值 67 對應大寫字母 'C'，以此類推。</li>
                        </ul>
                        <p>因此，<code>printf("%c", 66);</code> 會輸出 ASCII 值為 66 的字元，即大寫字母 'B'。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q19">下一題</button></div>
                </div>

                <div id="q19" class="quiz-card">
                    <h3>19. 美花使用 c++語言寫一支程式，需要使用者從鍵盤輸入密碼進行驗證，她應該使用下列哪一行程式碼才是正確的？</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) scanf("%i", passwd);</div>
                        <div class="option" data-option="B">(B) scanf("%i", &amp;passwd);</div>
                        <div class="option" data-option="C">(C) std::cin &gt;&gt; passwd;</div>
                        <div class="option" data-option="D">(D) std::cout &lt;&lt; passwd;</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C/C++ 輸入</h4>
                        <p>題目提到 "c++語言寫一支程式"，但選項中混合了 C 的 <code>scanf</code> 和 C++ 的 <code>cin</code>/<code>cout</code>。</p>
                        <p><b>對於 C 語言的 <code>scanf</code>：</b></p>
                        <ul>
                            <li><code>scanf</code> 函數用於從標準輸入（通常是鍵盤）讀取格式化輸入。</li>
                            <li>當讀取資料並存儲到變數中時，<code>scanf</code> 需要該變數的記憶體位址。因此，對於基本資料型別的變數 (如 <code>int</code>, <code>float</code>, <code>char</code>)，必須在變數名前使用取址運算子 <code>&</code>。</li>
                            <li><code>%i</code> (或 <code>%d</code>) 是用於讀取整數的格式指定字。</li>
                        </ul>
                        <p>分析 <code>scanf</code> 選項：</p>
                        <ul>
                            <li><b>(A) scanf("%i", passwd);</b> 錯誤。缺少取址運算子 <code>&</code>。<code>passwd</code> 本身代表變數的值，而不是其記憶體位址 (除非 <code>passwd</code> 是一個指標，但題目情境通常指普通變數)。</li>
                            <li><b>(B) scanf("%i", &amp;passwd);</b> 正確 (在 C 語言中)。它提供了 <code>passwd</code> 變數的記憶體位址，<code>scanf</code> 可以將輸入的整數存儲到該位址。</li>
                        </ul>
                        <p><b>對於 C++ 語言的 <code>std::cin</code>：</b></p>
                        <ul>
                            <li><code>std::cin</code> 是 C++ 標準輸入流物件。</li>
                            <li>它使用提取運算子 <code>>></code> 來讀取輸入。</li>
                            <li><code>std::cin >> variable;</code> 會自動處理變數的位址，不需要顯式使用 <code>&</code> (除非是讀取 C 風格字串到 <code>char</code> 陣列)。</li>
                        </ul>
                        <p>分析 C++ I/O 選項：</p>
                        <ul>
                            <li><b>(C) std::cin >> passwd;</b> 正確 (在 C++ 語言中)。這是標準的 C++ 從鍵盤讀取資料到變數 <code>passwd</code> 的方式。</li>
                            <li><b>(D) std::cout &lt;&lt; passwd;</b> 錯誤。<code>std::cout</code> 和 <code>&lt;&lt;</code> 用於輸出，不是輸入。</li>
                        </ul>
                        <p><b>判斷最佳答案：</b></p>
                        <p>題目說 "c++語言寫一支程式"。在 C++ 中，雖然可以使用 C 的 <code>scanf</code> (需要引入 <code>&lt;cstdio&gt;</code> 或 <code>&lt;stdio.h&gt;</code>)，但更符合 C++ 風格的是使用 <code>std::cin</code>。</p>
                        <p>然而，選項 (B) 和 (C) 在各自的語言上下文中都是「正確的」語法來讀取輸入。如果題目強調「C++語言」，則 (C) 更具 C++ 特色。但如果題目是混合考察，且 <code>passwd</code> 被假定為一個例如 <code>int</code> 型別的變數，那麼 (B) 的 <code>scanf</code> 形式是 C 語言中讀取整數的正確方式，並且在 C++ 中也是可用的。</p>
                        <p>鑑於這通常是基礎 C/C++ 題目，且 <code>scanf</code> 的 <code>&</code> 使用是常見考點，而題目提供的正確答案是 (B)，我們將以 (B) 為準，並理解其在 C 和 C++ (透過 C 相容性) 中的有效性。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q20">下一題</button></div>
                </div>

                <div id="q20" class="quiz-card">
                    <h3>20. 在 c++語言中，要使用 cout 物件將字串輸出，在原始檔中需要載入函式庫，下列哪一種寫法正確？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) #include &lt;stdio.h&gt;</div>
                        <div class="option" data-option="B">(B) #include &lt;stdio&gt;</div>
                        <div class="option" data-option="C">(C) #include &lt;iostream.h&gt;</div>
                        <div class="option" data-option="D">(D) #include &lt;iostream&gt;</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C++ 標準函式庫引用</h4>
                        <p>在 C++ 中，標準輸入/輸出操作（如使用 <code>std::cout</code> 和 <code>std::cin</code>）是由 <code>iostream</code> 函式庫提供的。</p>
                        <ul>
                            <li><b>(A) #include &lt;stdio.h&gt;:</b> 這是 C 語言的標準輸入/輸出函式庫，提供如 <code>printf</code> 和 <code>scanf</code> 等函數。雖然在 C++ 中為了相容性也可以使用，但它不是使用 <code>cout</code> 所需的函式庫。</li>
                            <li><b>(B) #include &lt;stdio&gt;:</b> 這是 C++ 中引用 C 標準函式庫的一種方式 (等同於 <code>#include &lt;cstdio&gt;</code>)。同樣，它提供 C 風格的 I/O，而非 <code>cout</code>。</li>
                            <li><b>(C) #include &lt;iostream.h&gt;:</b> 這是早期 C++（標準化之前）使用的標頭檔名稱。在現代標準 C++ 中，這個寫法已被棄用，不應再使用。</li>
                            <li><b>(D) #include &lt;iostream&gt;:</b> 這是現代標準 C++ 中用於輸入/輸出流操作的正確標頭檔。它定義了 <code>std::cout</code>, <code>std::cin</code>, <code>std::endl</code> 等物件和操縱符。</li>
                        </ul>
                        <p>因此，要使用 <code>std::cout</code>，必須包含 <code>&lt;iostream&gt;</code> 標頭檔。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q21">下一題</button></div>
                </div>

                <div id="q21" class="quiz-card">
                    <h3>21. 何種型別不是簡單資料型別(simple data type)？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 整數(integer)型別</div>
                        <div class="option" data-option="B">(B) 浮點數(float)型別</div>
                        <div class="option" data-option="C">(C) 邏輯(boolean)型別</div>
                        <div class="option" data-option="D">(D) 陣列(array)型別</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：簡單資料型別 vs. 複合資料型別</h4>
                        <p>簡單資料型別（也稱為基本資料型別或原始資料型別）通常是指那些不能再被分解為更小部分，並且直接表示單一值的型別。</p>
                        <p>複合資料型別（或結構化資料型別）是由其他型別（簡單的或複合的）組合而成的型別，可以表示更複雜的資料結構。</p>
                        <p>分析選項：</p>
                        <ul>
                            <li><b>(A) 整數(integer)型別:</b> 如 <code>int</code>, <code>short</code>, <code>long</code>, <code>char</code>。這些都是簡單資料型別，用於表示單一的整數值。</li>
                            <li><b>(B) 浮點數(float)型別:</b> 如 <code>float</code>, <code>double</code>。這些是簡單資料型別，用於表示單一的實數值。</li>
                            <li><b>(C) 邏輯(boolean)型別:</b> 如 C++ 中的 <code>bool</code> (值為 <code>true</code> 或 <code>false</code>)。這也是一個簡單資料型別，表示單一的邏輯值。 (在 C 語言中，傳統上用整數 0 表示 false，非 0 表示 true，C99 後引入 <code>_Bool</code>)。</li>
                            <li><b>(D) 陣列(array)型別:</b> 陣列是用於儲存固定大小、相同型別元素序列的複合資料型別。它是由多個簡單型別（或其他複合型別）的元素組成的。因此，陣列不是簡單資料型別。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q22">下一題</button></div>
                </div>

                <div id="q22" class="quiz-card">
                    <h3>22. 下列敘述何者錯誤？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 組合語言程式中也有變數及常數</div>
                        <div class="option" data-option="B">(B) 如果某變數在程式執行中都不改變值的話，可以宣告為常數</div>
                        <div class="option" data-option="C">(C) 變數可以設定為某個常數</div>
                        <div class="option" data-option="D">(D) 常數可以設定為某個變數</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：變數與常數的基本概念</h4>
                        <ul>
                            <li><b>(A) 組合語言程式中也有變數及常數：</b>正確。組合語言允許使用符號名稱（類似變數）來代表記憶體位址或數值（類似常數），以增加程式的可讀性。</li>
                            <li><b>(B) 如果某變數在程式執行中都不改變值的話，可以宣告為常數：</b>正確。這正是常數的用途。例如，在 C/C++ 中使用 <code>const</code> 關鍵字宣告的變數就是一個其值在初始化後不能被修改的常數。</li>
                            <li><b>(C) 變數可以設定為某個常數：</b>正確。這是變數賦值的常見操作，例如 <code>int x = 100;</code>，其中 <code>x</code> 是變數，<code>100</code> 是常數。</li>
                            <li><b>(D) 常數可以設定為某個變數：</b>錯誤。常數的定義是在編譯時期或初始化時其值就已固定，並且在程式執行過程中不能被修改。將一個常數的值設定為一個變數的值，意味著常數的值可能會隨變數的改變而改變，這違背了常數的定義。例如，<code>const int MY_CONST = someVariable;</code> 這樣的初始化是可以的（如果 <code>someVariable</code> 在此時是個編譯期常數或其值已知），但之後不能再寫 <code>MY_CONST = anotherVariable;</code>。更直接地說，你不能寫類似 <code>10 = x;</code> 這樣的語句。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q23">下一題</button></div>
                </div>

                <div id="q23" class="quiz-card">
                    <h3>23. 在 c 語言中沒有布林資料型別，因此將哪一個值視同為 false(假)？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) -100</div>
                        <div class="option" data-option="B">(B) -1</div>
                        <div class="option" data-option="C">(C) 0</div>
                        <div class="option" data-option="D">(D) 1</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C 語言中的布林邏輯</h4>
                        <p>傳統的 C 語言 (ANSI C / C89/C90) 並沒有內建的布林 (boolean) 資料型別關鍵字 (如 C++ 中的 <code>bool</code>)。</p>
                        <p>在 C 語言中，條件判斷和邏輯運算的真假是通過整數值來表示的：</p>
                        <ul>
                            <li><b>0 (零)：</b>被視為假 (False)。</li>
                            <li><b>任何非零值 (Non-zero value)：</b>被視為真 (True)。這包括正整數 (如 1, 100) 和負整數 (如 -1, -100)。</li>
                        </ul>
                        <p>C99 標準引入了 <code>_Bool</code> 型別和 <code>&lt;stdbool.h&gt;</code> 標頭檔，其中定義了 <code>bool</code>、<code>true</code> (通常定義為 1) 和 <code>false</code> (通常定義為 0)，但題目似乎指的是 C 語言更傳統的處理方式，或者即便在 C99/C11 中，底層的邏輯判斷仍然遵循 0 為假，非 0 為真的原則。</p>
                        <p>因此，在 C 語言中，值 0 被視為 false。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q24">下一題</button></div>
                </div>

                <div id="q24" class="quiz-card">
                    <h3>24. 請問若宣告一個 short int 的整數佔用 2 bytes 的記憶體空間，則此整數的表示範圍為下列何者？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) -2,147,483,648~2,147,483,647</div>
                        <div class="option" data-option="B">(B) 0~65,535</div>
                        <div class="option" data-option="C">(C) -32,768~32,767</div>
                        <div class="option" data-option="D">(D) 0~4,294,967,295</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：<code>short int</code> (有符號) 範圍</h4>
                        <p>題目明確指出 <code>short int</code> 占用 2 bytes。</p>
                        <p>2 bytes = 2 * 8 bits = 16 bits。</p>
                        <p><code>short int</code> 預設是有符號的。對於一個 n 位元的有符號整數，其表示範圍是：</p>
                        <p><code>-2<sup>(n-1)</sup></code> 到 <code>2<sup>(n-1)</sup> - 1</code></p>
                        <p>在此題中，n = 16。</p>
                        <ul>
                            <li>最小值：<code>-2<sup>(16-1)</sup> = -2<sup>15</sup> = -32768</code></li>
                            <li>最大值：<code>2<sup>(16-1)</sup> - 1 = 2<sup>15</sup> - 1 = 32768 - 1 = 32767</code></li>
                        </ul>
                        <p>所以，2 bytes 的 <code>short int</code> 能記錄的範圍是 -32,768 到 32,767。</p>
                        <p>分析其他選項：</p>
                        <ul>
                            <li>(A) -2,147,483,648 ~ 2,147,483,647：這通常是 4 bytes (32-bit) 有符號整數 (<code>int</code>) 的範圍。</li>
                            <li>(B) 0 ~ 65,535：這通常是 2 bytes (16-bit) 無符號整數 (<code>unsigned short int</code>) 的範圍 (2<sup>16</sup> - 1 = 65535)。</li>
                            <li>(D) 0 ~ 4,294,967,295：這通常是 4 bytes (32-bit) 無符號整數 (<code>unsigned int</code>) 的範圍 (2<sup>32</sup> - 1)。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q25">下一題</button></div>
                </div>

                <div id="q25" class="quiz-card">
                    <h3>25. 程式執行過程中，若變數發生溢位情形，其主要原因為何？</h3>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 以有限數目的位元儲存變數值</div>
                        <div class="option" data-option="B">(B) 電壓不穩定</div>
                        <div class="option" data-option="C">(C) 作業系統與程式不甚相容</div>
                        <div class="option" data-option="D">(D) 變數過多導致編譯器無法完全處理</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：整數溢位 (Overflow)</h4>
                        <p>整數溢位發生在嘗試將一個數值儲存到一個整數型別的變數中，但該數值超出了該型別所能表示的範圍時。</p>
                        <ul>
                            <li><b>(A) 以有限數目的位元儲存變數值：</b>正確。每個資料型態 (如 <code>int</code>, <code>short</code>, <code>char</code>) 都使用固定且有限的位元數來儲存資料。例如，一個 8 位元的無符號字元最大只能儲存到 255。如果試圖儲存 256，就會發生溢位。這個有限性是溢位的根本原因。</li>
                            <li><b>(B) 電壓不穩定：</b>電壓不穩定可能導致硬體故障或資料損壞，但它不是程式邏輯中「溢位」概念的直接原因。溢位是算術運算超出了資料型態的表示能力。</li>
                            <li><b>(C) 作業系統與程式不甚相容：</b>相容性問題可能導致程式無法執行或執行錯誤，但通常不直接稱為「溢位」。溢位是特定於資料型態表示範圍的問題。</li>
                            <li><b>(D) 變數過多導致編譯器無法完全處理：</b>編譯器對變數數量有限制，但這通常會導致編譯錯誤（例如符號表溢出），而不是執行時的算術溢位。算術溢位是關於單個變數的值超出了其型別的界限。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q26_part1">下一題</button></div>
                </div>

                <div id="q26_part1" class="quiz-card">
                    <h3>26. 下列程式片段的執行結果為何？</h3>
                    <p><sub>(注意：此題在原始題目中未提供程式片段。以下解釋為通用情況或基於選項推測。)</sub></p>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 1</div>
                        <div class="option" data-option="B">(B) 2</div>
                        <div class="option" data-option="C">(C) 4</div>
                        <div class="option" data-option="D">(D) 8</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路</h4>
                        <p>由於此問題沒有提供相關的程式片段，我們無法直接分析執行結果。然而，如果我們假設這是一個關於位元運算或簡單算術的常見問題，且答案是 (C) 4，那麼可能的程式片段可能是：</p>
                        <p><b>可能性 1: 左移運算</b></p>
                        <pre><code class="language-c">int x = 1;
x = x &lt;&lt; 2; // x 左移 2 位 (1 * 2^2)
// printf("%d", x); // 結果為 4</code></pre>
                        <p><b>可能性 2: 乘法</b></p>
                        <pre><code class="language-c">int x = 2;
x = x * 2;
// printf("%d", x); // 結果為 4</code></pre>
                        <p><b>可能性 3: 數值比較後賦值 (較不直接)</b></p>
                        <pre><code class="language-c">int a = 5, b = 3, result = 0;
if (a > b) {
    result = 4;
}
// printf("%d", result); // 結果為 4</code></pre>
                        <p>在沒有具體程式碼的情況下，我們只能推測。如果這是考試題目，通常會有對應的程式碼。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C) (根據題目選項)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q26_part2">下一題</button></div>
                </div>

                <div id="q26_part2" class="quiz-card">
                    <h3>26. 在 C/C++語言中，以下指令執行完後，顯示的值為何？</h3>
                    <pre><code class="language-c">printf("%o\n",15);</code></pre>
                    <button class="run-example-btn" data-code-id="q26_part2-code">運行示例</button>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 17</div>
                        <div class="option" data-option="B">(B) 15</div>
                        <div class="option" data-option="C">(C) F</div>
                        <div class="option" data-option="D">(D) 15.0</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：<code>printf</code> 八進位輸出</h4>
                        <p>指令 <code>printf("%o\n", 15);</code> 的含義是：</p>
                        <ul>
                            <li><code>%o</code>：這是一個格式指定字，告訴 <code>printf</code> 將對應的參數 (在此為整數 15) 以無符號八進位 (octal) 形式輸出。</li>
                            <li><code>15</code>：這是要被格式化的十進位整數。</li>
                            <li><code>\n</code>：輸出一個換行符。</li>
                        </ul>
                        <p>要將十進位數 15 轉換為八進位：</p>
                        <ul>
                            <li>15 ÷ 8 = 1 餘 7</li>
                            <li>1 ÷ 8 = 0 餘 1</li>
                        </ul>
                        <p>將餘數由下往上讀取，得到八進位表示為 17<sub>8</sub>。</p>
                        <p>因此，<code>printf("%o\n", 15);</code> 會輸出 "17" 後面跟著一個換行。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q27">下一題</button></div>
                </div>

                <div id="q27" class="quiz-card">
                    <h3>27. 下列那一個不是 C 語言的合法變數名稱？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) _Test</div>
                        <div class="option" data-option="B">(B) TEST</div>
                        <div class="option" data-option="C">(C) 5test</div>
                        <div class="option" data-option="D">(D) test1</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C 語言變數命名規則</h4>
                        <p>C 語言的識別字（包括變數名稱）命名規則：</p>
                        <ol>
                            <li>可以由英文字母 (a-z, A-Z)、數字 (0-9) 和底線 (<code>_</code>) 組成。</li>
                            <li>第一個字元必須是字母或底線。**不能是數字**。</li>
                            <li>區分大小寫。</li>
                            <li>不能是 C 語言的關鍵字 (如 <code>int</code>, <code>while</code> 等)。</li>
                        </ol>
                        <p>分析選項：</p>
                        <ul>
                            <li><b>(A) _Test:</b> 以底線開頭，後續為字母。合法。</li>
                            <li><b>(B) TEST:</b> 全部為大寫字母。合法。</li>
                            <li><b>(C) 5test:</b> 以數字 <code>5</code> 開頭。**不合法**，違反了規則 2。</li>
                            <li><b>(D) test1:</b> 以字母開頭，包含字母和數字。合法。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q28">下一題</button></div>
                </div>

                <div id="q28" class="quiz-card">
                    <h3>28. 在 C 語言中，下列那一種變數名稱是不合法？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) _Happy</div>
                        <div class="option" data-option="B">(B) Happy</div>
                        <div class="option" data-option="C">(C) 9Happy</div>
                        <div class="option" data-option="D">(D) Happy2</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C 語言變數命名規則</h4>
                        <p>再次參考 C 語言的識別字命名規則：</p>
                        <ol>
                            <li>可以由英文字母、數字和底線組成。</li>
                            <li>第一個字元必須是字母或底線。**不能是數字**。</li>
                            <li>區分大小寫。</li>
                            <li>不能是 C 語言的關鍵字。</li>
                        </ol>
                        <p>分析選項：</p>
                        <ul>
                            <li><b>(A) _Happy:</b> 以底線開頭，後續為字母。合法。</li>
                            <li><b>(B) Happy:</b> 以字母開頭，後續為字母。合法。</li>
                            <li><b>(C) 9Happy:</b> 以數字 <code>9</code> 開頭。**不合法**，違反了規則 2。</li>
                            <li><b>(D) Happy2:</b> 以字母開頭，包含字母和數字。合法。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q29">下一題</button></div>
                </div>

                <div id="q29" class="quiz-card">
                    <h3>29. 關於 C 程式語言中，使用 define 建立常數的方式，下列何者正確？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) define PI=3.14;</div>
                        <div class="option" data-option="B">(B) define PI 3.14;</div>
                        <div class="option" data-option="C">(C) #define PI=3.14</div>
                        <div class="option" data-option="D">(D) #define PI 3.14</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：<code>#define</code> 前置處理器指令</h4>
                        <p><code>#define</code> 是 C/C++ 中的一個前置處理器指令，用於定義巨集。當用於定義常數時，其基本語法是：</p>
                        <p><code>#define IDENTIFIER replacement_text</code></p>
                        <ul>
                            <li><code>#define</code> 必須以 <code>#</code> 符號開始，並且通常放在一行的開頭（前面可以有空白）。</li>
                            <li><code>IDENTIFIER</code> 是你定義的常數名稱（巨集名稱），通常習慣用大寫字母。</li>
                            <li><code>replacement_text</code> 是將在程式碼中取代 <code>IDENTIFIER</code> 的內容。</li>
                            <li><code>replacement_text</code> 之後不應有分號 <code>;</code>，因為 <code>#define</code> 是一個直接的文字替換，如果加了分號，分號也會成為替換內容的一部分，可能導致語法錯誤。</li>
                            <li><code>IDENTIFIER</code> 和 <code>replacement_text</code> 之間通常用一個或多個空格隔開。</li>
                        </ul>
                        <p>分析選項：</p>
                        <ul>
                            <li><b>(A) define PI=3.14;</b> 錯誤。缺少 <code>#</code>，且 <code>=</code> 不是必需的 (雖然有些編譯器可能容忍，但非標準)，結尾多了分號。</li>
                            <li><b>(B) define PI 3.14;</b> 錯誤。缺少 <code>#</code>，結尾多了分號。</li>
                            <li><b>(C) #define PI=3.14</b> 錯誤。<code>=</code> 不是標準 <code>#define</code> 語法的一部分來分隔名稱和值 (雖然某些編譯器可能接受，但會將 <code>=3.14</code> 整個作為替換文本)。標準是用空格。</li>
                            <li><b>(D) #define PI 3.14</b> 正確。以 <code>#</code> 開頭，名稱 <code>PI</code> 和值 <code>3.14</code> 以空格分隔，且結尾沒有分號。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q30">下一題</button></div>
                </div>

                <div id="q30" class="quiz-card">
                    <h3>30. 關於 C 程式語言的資料型態，下列敘述何者錯誤？</h3>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) float 資料型態可以儲存浮點數，數值精確度跟 double 資料型態相同</div>
                        <div class="option" data-option="B">(B) 宣告 int 資料型態可以儲存整數資料</div>
                        <div class="option" data-option="C">(C) double 資料型態可以儲存浮點數值</div>
                        <div class="option" data-option="D">(D) 宣告 char 資料型態可以儲存字元符號</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C 語言資料型態特性</h4>
                        <ul>
                            <li><b>(A) float 資料型態可以儲存浮點數，數值精確度跟 double 資料型態相同：</b>錯誤。
                                <ul>
                                    <li><code>float</code> (單精度浮點數) 通常使用 32 位元儲存。</li>
                                    <li><code>double</code> (雙精度浮點數) 通常使用 64 位元儲存。</li>
                                    <li>由於 <code>double</code> 使用更多的位元來表示尾數 (mantissa) 和指數 (exponent)，所以它具有比 <code>float</code> 更大的表示範圍和更高的數值精確度。<code>float</code> 的有效數字大約是 6-7 位十進位數，而 <code>double</code> 大約是 15-16 位十進位數。因此，它們的精確度是不同的。</li>
                                </ul>
                            </li>
                            <li><b>(B) 宣告 int 資料型態可以儲存整數資料：</b>正確。<code>int</code> 用於儲存整數。</li>
                            <li><b>(C) double 資料型態可以儲存浮點數值：</b>正確。<code>double</code> 用於儲存雙精度浮點數。</li>
                            <li><b>(D) 宣告 char 資料型態可以儲存字元符號：</b>正確。<code>char</code> 用於儲存單個字元 (其本質上也是一個小的整數值，對應字元的 ASCII 碼或其他字元編碼)。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (A)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q31">下一題</button></div>
                </div>

                <div id="q31" class="quiz-card"> <!-- Combined preamble and question -->
                    <h3>31. (A閱讀下文) 小芳在一個原本可以編譯(Compile)成功的程式中，在 main( )主程式內再加入行號 1 至行號 6 的程式碼，但加入後發 編譯錯誤的情況。<br>
                    <pre><code class="language-c">1 #define Value1  100
2 #define Value2 (Value1 - 1)
3 const  int  Value3;
4 int CheckValue = 0;
5 Value3 = Value2;
6 CheckValue = Value1 + Value3;</code></pre>
                    小芳刪除行號 1 至行號 5 中的哪一個部分後，可以使程式編譯成功？</h3>
                    <button class="run-example-btn" data-code-id="q31_32-code">運行示例 (Q31&32)</button>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) (Value1 - 1)</div>
                        <div class="option" data-option="B">(B) Value3 = Value2;</div>
                        <div class="option" data-option="C">(C) const</div>
                        <div class="option" data-option="D">(D) #define Value2 (Value1 - 1)</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：<code>const</code> 變數的初始化與賦值</h4>
                        <p>分析程式碼：</p>
                        <ul>
                            <li>行 1: <code>#define Value1 100</code> - 前置處理器將所有 <code>Value1</code> 替換為 <code>100</code>。</li>
                            <li>行 2: <code>#define Value2 (Value1 - 1)</code> - 前置處理器將所有 <code>Value2</code> 替換為 <code>(100 - 1)</code>，即 <code>(99)</code>。</li>
                            <li>行 3: <code>const int Value3;</code> - 宣告一個整數型別的<b>常數</b> <code>Value3</code>。<b>關鍵問題：</b><code>const</code> 變數必須在宣告時進行初始化，或者如果是在類別中作為成員，則需在建構函式的初始化列表中初始化。這裡 <code>Value3</code> 被宣告為 <code>const</code> 但沒有立即給予初始值。</li>
                            <li>行 4: <code>int CheckValue = 0;</code> - 宣告並初始化一個整數變數 <code>CheckValue</code>。</li>
                            <li>行 5: <code>Value3 = Value2;</code> - 試圖將 <code>Value2</code> (即 99) 賦值給 <code>Value3</code>。由於 <code>Value3</code> 在行 3 被宣告為 <code>const</code> 且未初始化，這裡有兩個問題：
                                <ol>
                                    <li>對未初始化的 <code>const</code> 變數進行賦值（如果編譯器允許延遲初始化，這一步本身就是賦值給 const）。</li>
                                    <li>更根本的是，<code>const</code> 變數一旦初始化後（在此情況下是未初始化），就不能再被賦予新值。</li>
                                </ol>
                                這行是主要的編譯錯誤來源。
                            </li>
                            <li>行 6: <code>CheckValue = Value1 + Value3;</code> - 如果行 5 導致編譯失敗，這行可能不會被編譯器完全分析，或者如果 <code>Value3</code> 因未初始化而值不確定，這裡也會有問題。</li>
                        </ul>
                        <p>要使程式編譯成功，最直接的方法是讓 <code>Value3</code> 可以被賦值。如果刪除行 3 中的 <code>const</code> 關鍵字，<code>Value3</code> 就會變成一個普通的 <code>int</code> 變數，行 5 的賦值 <code>Value3 = Value2;</code> 就會變得合法。</p>
                        <p>分析選項：</p>
                        <ul>
                            <li>(A) 刪除 <code>(Value1 - 1)</code>：這會使 <code>Value2</code> 的定義不完整，無法解決問題。</li>
                            <li>(B) 刪除 <code>Value3 = Value2;</code>：這會解決行 5 的賦值錯誤，但行 3 的 <code>const int Value3;</code> 仍然是一個未初始化的常數，在行 6 使用它會導致問題（使用未初始化的變數，且它是 const）。編譯器可能仍然會報錯說 const 變數未初始化。</li>
                            <li><b>(C) 刪除 <code>const</code>：</b>如果將行 3 改為 <code>int Value3;</code>，則 <code>Value3</code> 成為一個普通變數。行 5 <code>Value3 = Value2;</code> (即 <code>Value3 = 99;</code>) 就合法了。後續行 6 <code>CheckValue = Value1 + Value3;</code> (即 <code>CheckValue = 100 + 99;</code>) 也合法。這是最有效的修正。</li>
                            <li>(D) 刪除 <code>#define Value2 (Value1 - 1)</code>：這會使 <code>Value2</code> 未定義，導致行 5 出錯。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (C)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q32">下一題</button></div>
                </div>

                <div id="q32" class="quiz-card"> <!-- Combined preamble and question -->
                    <h3>32. (A閱讀下文) 小芳在一個原本可以編譯(Compile)成功的程式中，在 main( )主程式內再加入行號 1 至行號 6 的程式碼，但加入後發 編譯錯誤的情況。<br>
                    <pre><code class="language-c">1 #define Value1  100
2 #define Value2 (Value1 - 1)
3 const  int  Value3; // Assume 'const' is removed for this question as per Q31 fix
4 int CheckValue = 0;
5 Value3 = Value2;
6 CheckValue = Value1 + Value3;</code></pre>
                    程式修正後，當程式執行完行號 6 的時候，CheckValue 的值為下列何者？</h3>
                    <button class="run-example-btn" data-code-id="q31_32-code">運行示例 (Q31&32)</button>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 200</div>
                        <div class="option" data-option="B">(B) 199</div>
                        <div class="option" data-option="C">(C) 198</div>
                        <div class="option" data-option="D">(D) 100</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：追蹤變數值</h4>
                        <p>根據上一題 (Q31) 的分析，為了使程式能夠編譯成功，我們假設行 3 中的 <code>const</code> 關鍵字已被移除，使得 <code>Value3</code> 成為一個普通的 <code>int</code> 變數 (<code>int Value3;</code>)。</p>
                        <p>現在我們追蹤程式執行到行號 6 結束時 <code>CheckValue</code> 的值：</p>
                        <ol>
                            <li><b>行 1:</b> <code>#define Value1 100</code>
                                <ul><li>前置處理器指令。在編譯前，所有出現的 <code>Value1</code> 都會被替換為 <code>100</code>。</li></ul>
                            </li>
                            <li><b>行 2:</b> <code>#define Value2 (Value1 - 1)</code>
                                <ul><li>前置處理器指令。<code>Value2</code> 會被替換為 <code>(100 - 1)</code>，即 <code>(99)</code>。</li></ul>
                            </li>
                            <li><b>行 3:</b> <code>int Value3;</code> (假設 <code>const</code> 已移除)
                                <ul><li>宣告一個整數變數 <code>Value3</code>。此時其值未定。</li></ul>
                            </li>
                            <li><b>行 4:</b> <code>int CheckValue = 0;</code>
                                <ul><li>宣告並初始化整數變數 <code>CheckValue</code> 為 0。</li></ul>
                            </li>
                            <li><b>行 5:</b> <code>Value3 = Value2;</code>
                                <ul>
                                    <li>替換後：<code>Value3 = (99);</code></li>
                                    <li><code>Value3</code> 被賦值為 99。</li>
                                </ul>
                            </li>
                            <li><b>行 6:</b> <code>CheckValue = Value1 + Value3;</code>
                                <ul>
                                    <li>替換後：<code>CheckValue = 100 + Value3;</code></li>
                                    <li>代入 <code>Value3</code> 的值：<code>CheckValue = 100 + 99;</code></li>
                                    <li>計算結果：<code>CheckValue = 199;</code></li>
                                </ul>
                            </li>
                        </ol>
                        <p>因此，當程式執行完行號 6 時，<code>CheckValue</code> 的值為 199。</p>
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
                'q6-code': `#include <stdio.h>\n\nint main() {\n  printf("'%6.2f'", 597.7231);\n  printf("\\n");\n  printf("'%6.2f'", 1.2);\n  printf("\\n");\n  return 0;\n}`,
                'q8-code': `#include <stdio.h>\n\nint main() {\n  int x = 123;\n  printf("'%6d'",x);\n  printf("\\n");\n  int y = 1234567;\n  printf("'%6d'",y); // Will print all digits if number is wider than 6\n  printf("\\n");\n  return 0;\n}`,
                'q14-code': `#include <stdio.h>\n\nint main() {\n  float a=3.1415f;\n  printf("%.2f\\n", a);\n  float b=3.1495f;\n  printf("%.2f\\n", b); // Demonstrates rounding\n  return 0;\n}`,
                'q18-code': `#include <stdio.h>\n\nint main() {\n  printf("%c\\n",66);\n  printf("%c\\n",'B');\n  return 0;\n}`,
                'q26_part2-code': `#include <stdio.h>\n\nint main() {\n  printf("%o\\n",15);\n  return 0;\n}`,
                'q31_32-code': `#include <stdio.h>\n\n#define Value1  100\n#define Value2 (Value1 - 1)\n\nint main() {\n  // For Q31, 'const int Value3;' would cause a compile error on line with 'Value3 = Value2;'\n  // To make it runnable for Q32, we remove const from Value3's declaration.\n  int Value3; \n  int CheckValue = 0;\n\n  Value3 = Value2;\n  CheckValue = Value1 + Value3;\n\n  printf("Value1: %d\\n", Value1);\n  printf("Value2: %d\\n", Value2);\n  printf("Value3 (after assignment): %d\\n", Value3);\n  printf("CheckValue: %d\\n", CheckValue);\n\n  return 0;\n}`
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
            if (codeSamples['q6-code']) { // Check if a relevant qN-code exists
                 codeEditor.value = codeSamples['q6-code']; // Example for this set
            } else if (Object.keys(codeSamples).length > 0) {
                 codeEditor.value = codeSamples[Object.keys(codeSamples)[0]]; // Fallback to the first sample
            } else {
                 codeEditor.value = "// Welcome! Select a question with a code example, or write your own C/C++ code here.";
            }
        });
    </script>
</body>
</html>
>>>>>>> REPLACE
