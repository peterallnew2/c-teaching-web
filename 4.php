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
