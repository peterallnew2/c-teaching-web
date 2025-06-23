<?php
header('Content-Type: text/html; charset=utf-8');

// 根據 7-split.php 和您的指示，設定頁面變數
$page_title = "第二章 C的初步"; // 更新為第二章的標題
$content_title = "第二章 C語言基礎"; // 更新為第二章的內容標題

// 假設CSS和JS文件名與7-split.php一致，並添加 script3.js
$page_script_css ="
<link rel=\"stylesheet\" href=\"./styles.css\">
<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css\">
<link href=\"https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css\" rel=\"stylesheet\" />
";

$page_script_js ="
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js\"></script>
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js\"></script>
<script>
MathJax = {
  tex: {
    inlineMath: [['$', '$'], ['\\$', '\\$']],
    displayMath: [['$$', '$$'], ['\\$$', '\\$$']]
  },
  svg: {fontCache: 'global'}
};
</script>
<script id=\"MathJax-script\" async src=\"https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js\"></script>
<script src=\"./script2.js\"></script>
<script src=\"./script3.js\"></script>
<script src=\"./script.js\"></script>

"; // 添加了 script3.js

// 模拟 header.php 的包含 (如果7-split.php有的话)
// 通常 header.php 会包含 <html>, <head>, <body> 开头和导航等
// 这里我们直接构建完整的HTML结构，参照7-split.php的风格
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <?php echo $page_script_css; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&family=Source+Code+Pro:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* 7-split.php 中可能在 style.css 定义的类似布局，这里简单模拟 */
        body { display: flex; font-family: 'Noto Sans TC', sans-serif; margin:0; height:100vh; overflow: hidden; }
        .container { display: flex; width: 100%; height:100%; }
        .tutorial-content { flex: 0.7; padding: 20px; overflow-y: auto; border-right: 1px solid #ccc; height:100%; box-sizing: border-box;}
        .interactive-panel { flex: 0.3; padding: 20px; overflow-y: auto; height:100%; box-sizing: border-box; background-color: #f9f9f9;}
        .resizer { width: 5px; background: #ddd; cursor: col-resize; height:100%;}
        .knowledge-point { margin-bottom: 20px; padding:15px; border:1px solid #eee; border-radius:5px; background-color:#fff;}
        .knowledge-point h3 { margin-top:0;}
        .run-example-btn { background-color: #4CAF50; color: white; padding: 8px 15px; margin-top:10px; border: none; cursor: pointer; border-radius: 4px;}
        .run-example-btn:hover { background-color: #45a049;}
        #code-editor { width: 100%; height: 200px; margin-bottom: 10px; font-family: 'Source Code Pro', monospace; border: 1px solid #ccc; box-sizing: border-box;}
        #run-code-btn { background-color: #007bff; color: white; padding: 10px 15px; border: none; cursor: pointer; border-radius: 4px; display:block; width:100%; margin-bottom:10px;}
        #run-code-btn:hover { background-color: #0056b3;}
        #output-area { background-color: #222; color: #eee; padding: 10px; min-height: 100px; white-space: pre-wrap; font-family: 'Source Code Pro', monospace; border-radius: 4px; overflow-x: auto;}
        /* Quiz styles from 7-split.php (or styles.css) would apply here */
        .quiz-section { margin-top: 30px; }
        .quiz-card { margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; background-color: #fff; }
        .quiz-options .option { padding: 10px; margin: 5px 0; border: 1px solid #eee; cursor: pointer; border-radius: 3px; }
        .quiz-options .option:hover { background-color: #f0f0f0; }
        .explanation { display: none; margin-top: 10px; padding: 10px; background-color: #e9f5ff; border: 1px solid #b3d7ff; border-radius: 4px;}
        .explanation h4 { margin-top:0; }
        .next-btn-container { text-align: right; margin-top:10px; }
        .next-btn { background-color: #555; color:white; padding: 8px 15px; border:none; cursor:pointer; border-radius:4px;}
        .next-btn:hover { background-color: #333;}
        pre code {font-family: 'Source Code Pro', monospace;}
    </style>
</head>
<body>
    <div class="container">
        <main class="tutorial-content">
            <h1><?php echo htmlspecialchars($content_title); ?></h1>
            <?php
            // 模拟的从 2.txt 转换来的HTML内容
            // 注意：实际应用中，这部分内容会非常长，并且需要正确的BIG5转UTF-8和HTML格式化
            $chapter2_html_content = '
                <p>本章節將介紹C語言的基礎，包括其特性、基本結構、第一個C程式、編譯與執行過程、關鍵字、識別字以及資料的輸入輸出等重要概念。</p>

                <h2>2-1 C語言的特性與基本結構</h2>
                <div class="knowledge-point">
                    <h3>C語言的特性</h3>
                    <p>C語言是一種高階、結構化的程式語言，具備以下特性：</p>
                    <ul>
                        <li><strong>簡潔有力：</strong> 語法精簡，表達能力強。</li>
                        <li><strong>執行效率高：</strong> 產生的程式執行速度快，接近組合語言。</li>
                        <li><strong>功能豐富：</strong> 提供多樣的運算子和資料型態。</li>
                        <li><strong>移植性高：</strong> 在不同平台間稍作修改即可編譯執行。</li>
                    </ul>
                </div>
                <div class="knowledge-point">
                    <h3>C程式的基本結構</h3>
                    <p>一個C程式通常包含前置處理指令 (如 <code>#include</code>)、全域宣告、<code>main()</code>函式 (程式進入點)、使用者自訂函式和註解。</p>
                    <p>下面是一個最簡單的C程式範例，它會在螢幕上印出 "Hello, World!"：</p>
                    <button class="run-example-btn" data-code-id="ch2_hello_world">運行 Hello World 範例</button>
                </div>

                <h2>2-2 C程式的編譯與執行</h2>
                <div class="knowledge-point">
                    <h3>編譯與執行步驟</h3>
                    <p>C程式的執行過程通常包括：</p>
                    <ol>
                        <li><strong>編輯 (Edit)：</strong> 撰寫副檔名為 <code>.c</code> 的原始程式碼檔案。</li>
                        <li><strong>編譯 (Compile)：</strong> 使用C編譯器 (如 GCC, Clang) 將原始程式碼轉換為機器碼目的檔 (<code>.o</code> 或 <code>.obj</code>)。</li>
                        <li><strong>連結 (Link)：</strong> 將編譯產生的目的檔與所需的函式庫連結起來，產生可執行檔。</li>
                        <li><strong>執行 (Execute)：</strong> 運行產生的可執行檔。</li>
                    </ol>
                </div>

                <h2>2-3 C的保留字、關鍵字與識別字</h2>
                <div class="knowledge-point">
                    <h3>關鍵字 (Keywords)</h3>
                    <p>C語言有一些具有特殊意義的保留字，稱為關鍵字 (Keywords)，例如 <code>int</code>, <code>float</code>, <code>char</code>, <code>if</code>, <code>else</code>, <code>for</code>, <code>while</code>, <code>return</code>, <code>void</code>, <code>struct</code>, <code>sizeof</code> 等。這些關鍵字不能被用作變數名或函式名。</p>
                    <h3>識別字 (Identifiers)</h3>
                    <p>識別字是用來為變數、函式、陣列等程式實體命名的名稱。其命名規則如下：</p>
                    <ul>
                        <li>可以由英文字母 (a-z, A-Z)、數字 (0-9) 和底線 <code>_</code> 組成。</li>
                        <li>第一個字元必須是英文字母或底線 <code>_</code>。不能以數字開頭。</li>
                        <li>C語言嚴格區分大小寫 (例如，<code>myVar</code> 和 <code>myvar</code> 是不同的識別字)。</li>
                        <li>不能使用C語言的關鍵字作為識別字名稱。</li>
                    </ul>
                    <p>例如，<code>myVariable</code>, <code>_count123</code>, <code>user_age</code> 都是合法的識別字；而 <code>123test</code>, <code>my-var</code>, <code>int</code> 則是非法的。</p>
                </div>

                <h2>2-4 變數、常數與資料型態 (部分內容)</h2>
                <div class="knowledge-point">
                    <h3>變數 (Variables)</h3>
                    <p>在C語言中，變數是記憶體中一塊被命名的儲存空間，用來儲存資料，其值在程式執行過程中可以改變。在使用變數前必須先宣告，指定其資料型態和名稱。</p>
                    <button class="run-example-btn" data-code-id="ch2_variable_declaration">查看變數宣告與使用範例</button>
                    <h3>sizeof 運算子</h3>
                    <p><code>sizeof</code> 是一個運算子，用來取得某個資料型態或變數在記憶體中所佔用的位元組數。</p>
                    <button class="run-example-btn" data-code-id="ch2_sizeof_operator">查看 sizeof 運算子範例</button>
                </div>
                <div class="knowledge-point">
                    <h3>常數 (Constants)</h3>
                    <p>常數是在程式執行過程中其值不能被改變的量。</p>
                    <h4>使用 <code>const</code> 關鍵字定義常數</h4>
                    <button class="run-example-btn" data-code-id="ch2_const_variable">查看 const 常數範例</button>
                    <h4>使用 <code>#define</code> 前置處理指令定義常數</h4>
                    <button class="run-example-btn" data-code-id="ch2_define_constant">查看 #define 常數範例</button>
                    <h4>使用 <code>enum</code> (列舉) 定義常數</h4>
                    <button class="run-example-btn" data-code-id="ch2_enum_example">查看 enum 列舉範例</button>
                </div>

                <h2>2-7 基本輸入輸出 (printf 與 scanf) (部分內容)</h2>
                <div class="knowledge-point">
                    <h3><code>printf()</code> 格式化輸出</h3>
                    <p><code>printf()</code> 函式用於將資料依照指定的格式輸出到標準輸出裝置 (通常是螢幕)。</p>
                    <button class="run-example-btn" data-code-id="ch2_printf_examples">查看 printf 用法範例</button>
                    <h3><code>scanf()</code> 格式化輸入</h3>
                    <p><code>scanf()</code> 函式用於從標準輸入裝置 (通常是鍵盤) 讀取使用者輸入的資料，並依照指定的格式儲存到變數中。</p>
                    <button class="run-example-btn" data-code-id="ch2_scanf_example">查看 scanf 用法範例</button>
                </div>

                <hr>
                <p><em>（以上為第二章主要教學內容摘要，基於2.txt轉換並修復。练习题部分将沿用下方已有的互动题库结构。）</em></p>
            ';
            echo $chapter2_html_content;
            ?>

            <!-- 以下保留 7-split.php 中原有的 quiz-section 结构和内容，作为示例 -->
            <!-- 实际项目中，这里的题目也应来自 2.txt 或相应的题目数据库 -->
            <div class="quiz-section">
                <h2>2-5 程式設計實習 (互動題庫範例 - 沿用7-split.php結構)</h2>
                <p>完成左側的學習後，試著挑戰下面的題目，檢驗你的學習成果！</p>

                <div id="q1" class="quiz-card">
                    <h3>1. (範例題) 要在同一行程式碼中宣告多個整數變數，要使用哪一個符號間隔？</h3>
                    <div class="quiz-options" data-correct="A">
                        <div class="option" data-option="A">(A) <code>,</code> (逗號)</div>
                        <div class="option" data-option="B">(B) <code>.</code> (句點)</div>
                        <div class="option" data-option="C">(C) <code>；</code> (全形分號)</div>
                        <div class="option" data-option="D">(D) 以上皆非</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 考點說明：多變數宣告語法</h4><p>在 C 語言中，若要於單一敘述中宣告多個相同型別的變數，應使用半形的逗號 <code>,</code> 來分隔各個變數名稱。</p><pre><code class="language-c">// 正確語法\nint a = 1, b = 2, c = 3;</code></pre>
                        <h4>✗✗ 錯誤選項原因</h4><ul><li><b>(B) . (句點):</b> 在 C 中主要用於存取 struct 或 union 的成員。</li><li><b>(C) ； (全形分號):</b> C 語言的語法符號皆為半形，全形字元會導致編譯錯誤。</li></ul>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q2">下一題</button></div>
                </div>
                <div id="q2" class="quiz-card">
                    <h3>2. (範例題) 下面哪一個是合法的變數名稱（識別字）？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) <code>123go</code></div>
                        <div class="option" data-option="B">(B) <code>my-var</code></div>
                        <div class="option" data-option="C">(C) <code>int</code></div>
                        <div class="option" data-option="D">(D) <code>_countMe</code></div>
                    </div>
                    <div class="explanation"><h4>✓ 考點說明：識別字命名規則</h4><p>C 語言的識別字 (包含變數名稱) 只能由英文字母、數字和底線 <code>_</code> 組成，且不能以數字開頭。底線 <code>_</code> 是唯一一個可以作為開頭的非英文字母字元。關鍵字不能作為識別字。</p><h4>✗✗ 錯誤選項原因</h4><ul><li><b>(A) 123go:</b> 不能以數字開頭。</li><li><b>(B) my-var:</b> 不能包含特殊字元 <code>-</code>。</li><li><b>(C) int:</b> 是C語言的關鍵字。</li></ul></div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q_end">結束測驗</button></div>
                </div>
                 <div id="q_end" class="quiz-card">
                    <h3>測驗結束</h3>
                    <p>感謝您的作答！</p>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q1">重新開始</button></div>
                </div>
            </div>
        </main>

        <div class="resizer" id="dragMe"></div>

        <aside class="interactive-panel">
            <div class="interactive-panel-inner">
                <h3>程式碼編輯與執行區</h3>
                <div class="sandbox-container">
                    <p style="font-size:0.9em; color:#555;">點擊教學內容中的「運行/查看範例」按鈕，或在此處手動輸入C程式碼。</p>
                    <textarea id="code-editor" spellcheck="false" aria-label="C語言程式碼編輯器"></textarea>
                    <div class="sandbox-controls">
                        <button id="run-code-btn" title="此按鈕功能需由script2.js或script.js提供，本範例中不直接實現執行C的後端。">模擬執行 (輸出至下方)</button>
                    </div>
                    <pre id="output-area" aria-live="polite">輸出結果將顯示於此...</pre>
                </div>
                 <hr>
                 <div id="interactive-quiz-placeholder-info" style="text-align:center; padding:20px; color:#777;">
                    <p>（右側互動題庫區將由JavaScript動態載入）</p>
                    <p>（目前上方主要教學區的題庫為HTML靜態範例，用於展示結構）</p>
                 </div>
            </div>
        </aside>
    </div>

    <?php echo $page_script_js; ?>
    <?php // 模拟 footer.php 的包含 (如果7-split.php有的话) ?>
</body>
</html>
