<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C 語言互動教學：變數、常數與基本輸出入</title>

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
            line-height: 1.8;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            max-width: 1600px;
            margin: 0 auto;
            padding: 20px;
        }
        .tutorial-content {
            width: 100%;
            padding-right: 20px;
            box-sizing: border-box;
        }
        .interactive-panel {
            width: 100%;
            position: sticky;
            top: 20px;
            height: calc(100vh - 40px);
        }
        @media (min-width: 1024px) {
            .tutorial-content {
                width: 60%;
            }
            .interactive-panel {
                width: 40%;
            }
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
        .sandbox-container, .mathjax-renderer, .quiz-section {
            background-color: var(--card-bg);
            border-radius: 8px;
            padding: 20px;
            border: 1px solid var(--border-color);
        }
        .interactive-panel-inner {
            display: flex;
            flex-direction: column;
            height: 100%;
            gap: 20px;
        }
        .sandbox-container {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .sandbox-container h3, .mathjax-renderer h3 {
            margin-top: 0;
            color: var(--primary-color);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
        }
        #code-editor {
            width: 100%;
            height: 100%;
            flex-grow: 1;
            background-color: var(--code-bg);
            color: var(--text-color);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-family: var(--font-code);
            font-size: 1em;
            padding: 10px;
            box-sizing: border-box;
            resize: vertical;
        }
        .sandbox-controls {
            display: flex;
            justify-content: flex-end;
            padding: 10px 0;
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
        #output-area {
            background-color: #000;
            color: #fff;
            padding: 15px;
            border-radius: 4px;
            font-family: var(--font-code);
            white-space: pre-wrap;
            min-height: 50px;
            margin-top: 10px;
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
                        <h4>✓ 考點說明：多變數宣告語法</h4>
                        <p>在 C 語言中，若要於單一敘述中宣告多個相同型別的變數，應使用半形的逗號 <code>,</code> 來分隔各個變數名稱。</p>
                        <pre><code class="language-c">// 正確語法
int a = 1, b = 2, c = 3;</code></pre>
                        <h4>✗ 錯誤選項原因</h4>
                        <ul>
                            <li><b>(B) . (句點):</b> 在 C 中主要用於存取 struct 或 union 的成員。</li>
                            <li><b>(C) ； (全形分號):</b> C 語言的語法符號皆為半形，全形字元會導致編譯錯誤。</li>
                            <li><b>(D) . (句號):</b> 同 (B)。</li>
                        </ul>
                    </div>
                    <div class="next-btn-container">
                        <button class="next-btn" data-target="#q2">下一題</button>
                    </div>
                </div>

                <div id="q2" class="quiz-card">
                    <h3>2. 下面哪一個是合法的變數名稱？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) %123abc</div>
                        <div class="option" data-option="B">(B) &123abc</div>
                        <div class="option" data-option="C">(C) @123abc</div>
                        <div class="option" data-option="D">(D) _123abc</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 考點說明：識別字命名規則</h4>
                        <p>C 語言的識別字 (包含變數名稱) 只能由英文字母、數字和底線 <code>_</code> 組成，且不能以數字開頭。底線 <code>_</code> 是唯一一個可以作為開頭的非英文字母字元。</p>
                        <h4>✗ 錯誤選項原因</h4>
                        <ul>
                            <li><b>(A) %123abc:</b> 包含特殊字元 <code>%</code>，不合法。</li>
                            <li><b>(B) &123abc:</b> 包含特殊字元 <code>&</code>，不合法。</li>
                            <li><b>(C) @123abc:</b> 包含特殊字元 <code>@</code>，不合法。</li>
                        </ul>
                    </div>
                     <div class="next-btn-container">
                        <button class="next-btn" data-target="#q3">下一題</button>
                    </div>
                </div>

                <div id="q3" class="quiz-card">
                    <h3>3. 在 C/C++ 中要宣告一個常數，要使用哪一個關鍵字？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) define</div>
                        <div class="option" data-option="B">(B) set</div>
                        <div class="option" data-option="C">(C) const</div>
                        <div class="option" data-option="D">(D) invariant</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 考點說明：常數宣告</h4>
                        <p>在 C/C++ 中，`const` 是一個型別修飾符，用於宣告一個值在程式執行期間不能被修改的常數。這是宣告具備型別安全性常數的標準作法。</p>
                         <pre><code class="language-c">// 使用 const 宣告一個整數常數
const int MAX_SCORE = 100;</code></pre>
                        <h4>✗ 錯誤選項原因</h4>
                        <ul>
                            <li><b>(A) define:</b> `define` 是前置處理器指令，不是 C 語言的關鍵字。它執行的是簡單的文本替換，不進行型別檢查。</li>
                            <li><b>(B) set:</b> 不是 C/C++ 的關鍵字。</li>
                            <li><b>(D) invariant:</b> 不是 C/C++ 的標準關鍵字。</li>
                        </ul>
                    </div>
                    <div class="next-btn-container">
                        <button class="next-btn" data-target="#q4">下一題</button>
                    </div>
                </div>

                <div id="q4" class="quiz-card">
                    <h3>4. 在 C 語言中運算式 `sizeof(x)` 的結果為 4，下列何者<b>不是</b>其代表的意義？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) x 是 int 資料型別的變數</div>
                        <div class="option" data-option="B">(B) 變數 x 使用 4 byte 的記憶體大小</div>
                        <div class="option" data-option="C">(C) 變數 x 的值是 4</div>
                        <div class="option" data-option="D">(D) sizeof 是 C 語言的運算子</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 考點說明：`sizeof` 運算子</h4>
                        <p>`sizeof` 是一個編譯時運算子，它回傳一個變數或資料型別在記憶體中所佔用的空間大小，單位是位元組(byte)。它回傳的是「大小」，而不是變數儲存的「值」。</p>
                        <h4>✗ 錯誤選項原因</h4>
                        <ul>
                             <li><b>(A) x 是 int 資料型別的變數:</b> 在多數現代系統中，`int` 型別的大小就是 4 bytes，所以這是一個非常可能的情況。</li>
                             <li><b>(B) 變數 x 使用 4 byte 的記憶體大小:</b> 這是 `sizeof(x)` 回傳 4 的直接意義。</li>
                             <li><b>(D) sizeof 是 C 語言的運算子:</b> `sizeof` 是 C 語言內建的運算子，不是函式。</li>
                             <li><b>(C) 變數 x 的值是 4:</b> 這是唯一錯誤的敘述。`sizeof` 與變數 `x` 裡面儲存的值無關。例如 `int x = 999;`，`sizeof(x)` 仍然是 4，但 `x` 的值是 999。</li>
                        </ul>
                    </div>
                    <div class="next-btn-container">
                        <button class="next-btn" data-target="#q5">下一題</button>
                    </div>
                </div>

                <div id="q5" class="quiz-card">
                    <h3>5. 君偉在 C++ 程式中宣告一個變數，但在編譯時出現錯誤訊息，可能是使用哪一個變數名稱導致？</h3>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 5566team</div>
                        <div class="option" data-option="B">(B) _5566team</div>
                        <div class="option" data-option="C">(C) team5566</div>
                        <div class="option" data-option="D">(D) TEAM5566</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 考点说明：識別字命名規則</h4>
                        <p>根據 C/C++ 的識別字命名規則，名稱不能以數字開頭。</p>
                        <h4>✗ 錯誤選項原因</h4>
                        <ul>
                            <li><b>(A) 5566team:</b> 以數字 `5` 開頭，違反命名規則，會導致編譯錯誤。</li>
                            <li><b>(B) _5566team:</b> 以底線開頭是合法的。</li>
                            <li><b>(C) team5566:</b> 由字母和數字組成，且非數字開頭，是合法的。</li>
                            <li><b>(D) TEAM5566:</b> 由字母和數字組成，且非數字開頭，是合法的。C 語言區分大小寫，這是一個與 `team5566` 不同的合法變數名。</li>
                        </ul>
                    </div>
                    <div class="next-btn-container">
                        <button class="next-btn" data-target="#q6">下一題</button>
                    </div>
                </div>

                <div id="q6" class="quiz-card">
                    <h3>6. 網紅甄美麗拍攝一支 C 語言的教學影片，但部份內容有誤，請指出下列敘述何者錯誤？</h3>
                    <div class="quiz-options" data-correct="C">
                        <div class="option" data-option="A">(A) 程式執行時，變數會暫時存在於記憶體中</div>
                        <div class="option" data-option="B">(B) 要宣告常數，需使用關鍵字 const</div>
                        <div class="option" data-option="C">(C) 常數在程式執行時，其值會常常改變</div>
                        <div class="option" data-option="D">(D) double 是浮點數資料型別，大小為 8 byte</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 考點說明：常數 (Constant) 的定義</h4>
                        <p>常數 (Constant) 的核心特性就是其值在被定義後就「不能」被改變。「常數」的「常」字意指「恆常不變」，與「常常改變」的意義完全相反。</p>
                        <h4>✗ 錯誤選項原因</h4>
                        <ul>
                            <li><b>(A) 正確:</b> 變數是程式用來儲存資料的記憶體空間的名稱，資料確實暫存於記憶體中。</li>
                            <li><b>(B) 正確:</b> `const` 是宣告常數的標準關鍵字。</li>
                            <li><b>(D) 正確:</b> `double` 是一種雙精度浮點數資料型別，在大多數系統上佔用 8 bytes。</li>
                        </ul>
                    </div>
                    <div class="next-btn-container">
                        <button class="next-btn" data-target="#q7">下一題</button>
                    </div>
                </div>

                <div id="q7" class="quiz-card">
                    <h3>7. 在 C/C++ 程式語言中，下列何者不是正確的變數名稱命名規則？</h3>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) 英文的大小寫視為相同</div>
                        <div class="option" data-option="B">(B) 不可以使用數字開頭</div>
                        <div class="option" data-option="C">(C) 不能使用 int 或 float 做為變數名稱</div>
                        <div class="option" data-option="D">(D) 儘可能使用有意義的名稱</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 考點說明：C 語言的 Case-Sensitivity (大小寫敏感性)</h4>
                        <p>C/C++ 是大小寫敏感 (Case-Sensitive) 的語言。這意味著 `myVariable`、`MyVariable` 和 `myvariable` 會被視為三個完全不同的變數。</p>
                        <h4>✗ 錯誤選項原因</h4>
                        <ul>
                            <li><b>(B) 正確規則:</b> 識別字不能以數字開頭。</li>
                            <li><b>(C) 正確規則:</b> `int` 和 `float` 是語言的關鍵字 (Keywords)，不能用作變數名稱。</li>
                            <li><b>(D) 最佳實踐:</b> 雖然語法上允許無意義的變數名 (如 `x`, `a1`)，但為了程式碼的可讀性和可維護性，強烈建議使用有意義的名稱 (如 `userAge`, `totalScore`)。這是一條重要的程式設計風格指南。</li>
                        </ul>
                    </div>
                    <div class="next-btn-container">
                        <button class="next-btn" data-target="#q8">下一題</button>
                    </div>
                </div>

                <div id="q8" class="quiz-card">
                    <h3>8. 宣告一個字元變數 y，何者是正確的語法？</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) char y="a";</div>
                        <div class="option" data-option="B">(B) char y='a';</div>
                        <div class="option" data-option="C">(C) char y=a;</div>
                        <div class="option" data-option="D">(D) char y=[a];</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 考點說明：字元 (char) 字面值</h4>
                        <p>在 C 語言中，單一字元常數 (character literal) 必須用單引號 <code>' '</code> 包圍。</p>
                        <h4>✗ 錯誤選項原因</h4>
                        <ul>
                            <li><b>(A) char y="a";:</b> 雙引號 <code>" "</code> 用於定義字串 (string literal)。`"a"` 實際上是一個包含字元 `'a'` 和一個空終止符 <code>'\0'</code> 的字元陣列。將一個字串指派給 `char` 變數是型別不符的錯誤。</li>
                            <li><b>(C) char y=a;:</b> 如果 `a` 不是一個已宣告的變數，這會導致編譯錯誤 (未定義的識別字)。如果 `a` 是一個變數，這會將 `a` 的值指派給 `y`，而不是字元 'a' 本身。</li>
                            <li><b>(D) char y=[a];:</b> 方括號 `[ ]` 在 C 中主要用於陣列的宣告和索引，這種語法是無效的。</li>
                        </ul>
                    </div>
                    <div class="next-btn-container">
                        <button class="next-btn" data-target="#q9">下一題</button>
                    </div>
                </div>

                <div id="q9" class="quiz-card">
                    <h3>9. C++ 程式碼中的某行指令 `#define PI 3.14` 其所代表的意思是？</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 宣告變數 PI，指定初始值為 3.14</div>
                        <div class="option" data-option="B">(B) 程式碼中所有的 PI 都替換成 3.14</div>
                        <div class="option" data-option="C">(C) 只是一行註解，不會被編譯</div>
                        <div class="option" data-option="D">(D) 實作一物件 PI 且初始值為 3.14</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 考點說明：`#define` 前置處理器指令</h4>
                        <p>`#define` 是一個前置處理器 (Preprocessor) 指令。它告訴編譯器在實際編譯開始之前，先在整個程式碼檔案中進行一次「尋找與取代」的動作。在此例中，它會將所有出現的 `PI` 這個標記，無條件地替換成 `3.14` 這段文字。</p>
                        <h4>✗ 錯誤選項原因</h4>
                        <ul>
                            <li><b>(A) 宣告變數:</b> `PI` 不是一個變數。它沒有型別，也沒有記憶體位址。宣告變數應使用 `const double PI = 3.14;` 這樣的語法。</li>
                            <li><b>(C) 註解:</b> C 語言的單行註解是 `//`，多行註解是 `/* ... */`。`#define` 是有實際功能的指令。</li>
                            <li><b>(D) 實作物件:</b> C++ 中實作物件通常是透過 `class` 或 `struct` 關鍵字，`#define` 與物件導向無關。</li>
                        </ul>
                    </div>
                    <div class="next-btn-container">
                        <button class="next-btn" data-target="#q10">下一題</button>
                    </div>
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
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) 0</div>
                        <div class="option" data-option="B">(B) 1</div>
                        <div class="option" data-option="C">(C) 2</div>
                        <div class="option" data-option="D">(D) 3</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 考點說明：`enum` (列舉) 的值分配</h4>
                        <p>在 `enum` 中，如果沒有為成員明確指定值，它會自動被設定為前一個成員的值加 1。如果第一個成員沒有指定值，則預設為 0。</p>
                        <h4>✓ 逐行程式碼註釋</h4>
                        <pre><code class="language-c">// 宣告一個名為 color 的列舉型別
// Red 被明確指定為 1
// Blue 未指定，所以其值為 Red + 1 = 2
// Yellow 未指定，所以其值為 Blue + 1 = 3
// Green = 4, Black = 5, White = 6
enum color {Red=1, Blue, Yellow, Green, Black, White};

// 宣告一個 color 型別的變數 c，並將其值設為 Yellow
// 此時 c 的內部整數值為 3
color c = Yellow;

// 使用 %d 格式化輸出整數，將 c 的值 (3) 印出
printf("%d", c);</code></pre>
                        <p>因此，程式會輸出 `3`。</p>
                    </div>
                     <div class="next-btn-container">
                        <button class="next-btn" data-target="#q1">回到第一題</button>
                    </div>
                </div>


            </div>

        </main>

        <aside class="interactive-panel">
            <div class="interactive-panel-inner">
                <div class="sandbox-container">
                    <h3>▶ 程式碼沙箱 (Code Sandbox)</h3>
                    <p style="font-size: 0.9em; margin-top: -10px; opacity: 0.8;">點擊左側「運行示例」或直接在此編輯程式碼。</p>
                    <textarea id="code-editor" spellcheck="false"></textarea>
                    <div class="sandbox-controls">
                        <button id="run-code-btn">編譯與執行</button>
                    </div>
                    <pre id="output-area" aria-live="polite">輸出結果將顯示於此...</pre>
                </div>

                <div class="mathjax-renderer">
                    <h3>▶ 動態公式渲染器 (MathJax)</h3>
                    <p>本站已整合 MathJax，可優雅地呈現數學與指標運算式。例如：</p>
                    <p>指標 `p` 指向陣列 `arr`，存取第 `i` 個元素：$*(p+i)$</p>
                    <p>計算 `double` 型別的大小：`sizeof(double)`</p>
                    <p>二次方程式公式：$x = {-b \pm \sqrt{b^2-4ac} \over 2a}$</p>
                </div>
            </div>
        </aside>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Sample Code Snippets ---
            const codeSamples = {
                'var-declare': `#include <stdio.h>\n\nint main() {\n    // 宣告一個整數變數 age\n    int age;\n\n    // 指定(assign)值給 age\n    age = 25;\n\n    // 宣告字元變數並在宣告時給予初始值\n    char grade = 'A';\n\n    printf("年齡: %d\\n", age);\n    printf("等級: %c\\n", grade);\n\n    return 0;\n}`,
                'multi-declare': `#include <stdio.h>\n\nint main() {\n    // 在同一行宣告三個 double 型別的變數\n    double price = 99.9, weight = 5.2, tax = 0.05;\n\n    printf("價格: %.2f\\n", price);\n    printf("重量: %.1f\\n", weight);\n    printf("稅率: %.2f\\n", tax);\n\n    return 0;\n}`,
                'sizeof-op': `#include <stdio.h>\n#include <stddef.h> // For size_t\n\nint main() {\n    int a;\n    double d;\n    char c;\n\n    // 使用 %zu 來印出 size_t 型別是最佳實踐\n    printf("int 的大小: %zu bytes\\n", sizeof(a));\n    printf("double 的大小: %zu bytes\\n", sizeof(d));\n    printf("char 的大小: %zu bytes\\n", sizeof(c));\n\n    return 0;\n}`,
                'const-keyword': `#include <stdio.h>\n\nint main() {\n    const int MAX_ATTEMPTS = 3;\n\n    printf("最大嘗試次數為: %d\\n", MAX_ATTEMPTS);\n\n    // 下面這行如果取消註解，將會導致編譯錯誤\n    // MAX_ATTEMPTS = 4; // Error: assignment of read-only variable\n\n    return 0;\n}`,
                'define-directive': `#include <stdio.h>\n\n#define PI 3.14159\n\nint main() {\n    double radius = 10.0;\n    double area = PI * radius * radius;\n\n    printf("半徑為 %.1f 的圓面積為: %f\\n", radius, area);\n\n    return 0;\n}`,
                'enum-type': `#include <stdio.h>\n\n// 建立一個列舉型態 Action，有 5 個成員\n// 若未指定，預設從 0 開始遞增\nenum Action { UP, DOWN, LEFT, RIGHT, STOP };\n\nint main() {\n    // 宣告 Action 列舉變數 act，指定為 UP\n    enum Action act = UP;\n    printf("act 的值是 (UP): %d\\n", act);\n\n    // 指定 act 為 Stop\n    act = STOP;\n    printf("act 的值是 (STOP): %d\\n", act);\n\n    return 0;\n}`
            };

            const codeEditor = document.getElementById('code-editor');
            const outputArea = document.getElementById('output-area');
            const runCodeBtn = document.getElementById('run-code-btn');

            // --- Code Sandbox Logic ---
            // Populate sandbox from "Run Example" buttons
            document.querySelectorAll('.run-example-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const codeId = button.getAttribute('data-code-id');
                    if (codeSamples[codeId]) {
                        codeEditor.value = codeSamples[codeId];
                        outputArea.textContent = '程式碼已載入。點擊「編譯與執行」來查看結果。';
                        // Scroll to the sandbox for better UX on mobile
                        document.querySelector('.interactive-panel').scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });

            // Simulate compilation and execution
            runCodeBtn.addEventListener('click', () => {
                const userCode = codeEditor.value;
                outputArea.textContent = '編譯中...\n';

                // --- Simple Simulation of C execution ---
                // This is a front-end simulation. A real implementation would use
                // a server-side compiler or a WebAssembly-based one like Emscripten.
                let output = '';
                if (userCode.includes('printf')) {
                    if (userCode.includes('var-declare')) {
                        output = '年齡: 25\n等級: A';
                    } else if (userCode.includes('multi-declare')) {
                        output = '價格: 99.90\n重量: 5.2\n稅率: 0.05';
                    } else if (userCode.includes('sizeof-op')) {
                        output = 'int 的大小: 4 bytes\ndouble 的大小: 8 bytes\nchar 的大小: 1 bytes';
                    } else if (userCode.includes('const-keyword')) {
                        if (userCode.match(/MAX_ATTEMPTS\s*=\s*4/)) {
                           output = '編譯錯誤:\nError: assignment of read-only variable \'MAX_ATTEMPTS\'.';
                        } else {
                           output = '最大嘗試次數為: 3';
                        }
                    } else if (userCode.includes('define-directive')) {
                        output = '半徑為 10.0 的圓面積為: 314.159000';
                    } else if (userCode.includes('enum-type')) {
                        output = 'act 的值是 (UP): 0\nact 的值是 (STOP): 4';
                    } else if (userCode.includes('color c = Yellow;')) { // For quiz Q10
                        output = '3';
                    }
                     else {
                        output = '偵測到 printf，但無匹配的模擬輸出。\n這是一個前端模擬，請嘗試預設範例。';
                    }
                } else if (userCode.trim() === '') {
                    output = '錯誤: 程式碼為空。'
                } else {
                    output = '執行完畢，無可見輸出。';
                }

                setTimeout(() => {
                    outputArea.textContent = `▶ 執行結果:\n\n${output}`;
                }, 500); // Simulate delay
            });

            // --- Quiz Logic ---
            document.querySelectorAll('.quiz-options').forEach(optionsContainer => {
                optionsContainer.addEventListener('click', function(e) {
                    if (e.target.classList.contains('option') && !this.classList.contains('answered')) {
                        const selectedOption = e.target;
                        const correctAnswer = this.getAttribute('data-correct');
                        const selectedAnswer = selectedOption.getAttribute('data-option');

                        this.classList.add('answered');

                        // Show check/cross marks
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
                           opt.classList.add('answered'); // Prevent re-hover effects
                        });

                        // Show explanation
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

            // Set initial code in editor
            codeEditor.value = codeSamples['var-declare'];
        });
    </script>
</body>
</html>
