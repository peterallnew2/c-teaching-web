<?php
header('Content-Type: text/html; charset=utf-8');

?>


<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C 語言互動教學 (Emscripten & WASM)</title>

    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>

    <script>
    MathJax = {
      tex: {
        inlineMath: [['$', '$'], ['\$', '\$']],
        displayMath: [['$$', '$$'], ['\$$', '\$$']]
      }
    };
    </script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&family=Source+Code+Pro:wght@400;500&display=swap" rel="stylesheet">
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
                <pre><code class="language-c">int score = 100, level = 極5, players = 4;</code></pre>
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
                        <h4>✗✗ 錯誤選項原因</h4><ul><li><b>(B) . (句點):</b> 在 C 中主要用於存取 struct 或 union 的成員。</li><li><b>(C) ； (全形分號):</b> C 語言的語法符號皆為半形，全形字元會導致編譯錯誤。</li><li><b>(D) . (句號):</b> 同 (B)。</li></ul>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q2">下一題</button></div>
                </div>
                <div id="q2" class="quiz-card">
                    <h3>2. 下面哪一個是合法的變數名稱？</h3>
                    <div class="quiz-options" data-correct="D"><div class="option" data-option="A">(A) %123abc</div><div class="option" data-option="B">(B) &123abc</div><div class="option" data-option="C">(C) @123abc</div><div class="option" data-option="D">(D) _123abc</div></div>
                    <div class="explanation"><h4>✓ 考點說明：識別字命名規則</h4><p>C 語言的識別字 (包含變數名稱) 只能由英文字母、數字和底線 <code>_</code> 組成，且不能以數字開頭。底線 <code>_</code> 是唯一一個可以作為開頭的非英文字母字元。</p><h4>✗✗ 錯誤選項原因</h4><ul><li><b>(A) %123abc:</b> 包含特殊字元 <code>%</code>，不合法。</li><li><b>(B) &123abc:</b> 包含特殊字元 <code>&</code>，不合法。</li><li><b>(C) @123abc:</b> 包含特殊字元 <code>@</code>，不合法。</li></ul></div>
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

    <!-- 引入外部JavaScript文件 -->
    <script src="script2.js"></script>
    <script src="script.js"></script>

</body>
</html>
