<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C++ 物件導向基礎 (dd7-1)</title>

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
            <h1>C++ 語言練習：第七章 - 結構與類別基礎</h1>
            <p>本頁面為 C++/C 語言第七章練習題 (第 1-33 題)。此章節主要探討 C++ 中的結構(struct)與類別(class)，物件導向程式設計 (OOP) 的基本概念，包括建構子、解構子、繼承、封裝、`this` 指標、以及 `static` 成員等。請仔細分析每個問題，並利用右側的沙箱進行實作與驗證 (多數範例將以 C++ 編譯)。</p>

            <div class="quiz-section">
                <h2>第七章 互動練習題組 (1/?)</h2>
                <p>請挑戰下面的題目，檢驗您的學習成果！</p>
                <!-- QUIZ CARDS START -->
                <div id="q1" class="quiz-card">
                    <h3>1. 關於 c++語言的結構(struct)和類別(class)，下列哪一個敘述正確？</h3>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) c++是物件導向語言，使用類別來定義資料和操作資料的方法</div>
                        <div class="option" data-option="B">(B) 結構是使用者自已建立的資料型態，包含多個成員</div>
                        <div class="option" data-option="C">(C) 一個類別可以有多個物件的實作</div>
                        <div class="option" data-option="D">(D) 以上皆是</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C++ 結構與類別</h4>
                        <ul>
                            <li><strong>(A) c++是物件導向語言，使用類別來定義資料和操作資料的方法：</strong> 正確。類別 (class) 是 C++ 物件導向的核心，用於封裝資料 (成員變數) 和操作這些資料的方法 (成員函式)。</li>
                            <li><strong>(B) 結構是使用者自已建立的資料型態，包含多個成員：</strong> 正確。結構 (struct) 允許使用者將不同型態的資料組合成一個新的自訂資料型態。</li>
                            <li><strong>(C) 一個類別可以有多個物件的實作：</strong> 正確。類別是藍圖或模板，物件 (object) 是根據這個藍圖建立的實例 (instance)。一個類別可以實例化成多個物件。</li>
                            <li><strong>(D) 以上皆是：</strong> 因為 (A), (B), (C) 都正確。</li>
                        </ul>
                        <p>在 C++ 中，<code>struct</code> 和 <code>class</code> 非常相似，主要區別在於預設的成員存取權限：<code>struct</code> 的成員預設為 <code>public</code>，而 <code>class</code> 的成員預設為 <code>private</code>。</p>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (D)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q2">下一題</button></div>
                </div>

                <div id="q2" class="quiz-card">
                    <h3>2. 有關 c++語言的類別描述，下列何者錯誤？</h3>
                    <div class="quiz-options" data-correct="B">
                        <div class="option" data-option="A">(A) 類別可以實現 c++物件導向的特性</div>
                        <div class="option" data-option="B">(B) 一個類別只能產生一個物件實例</div>
                        <div class="option" data-option="C">(C) 類別的建構子可以重載</div>
                        <div class="option" data-option="D">(D) 類別的解構子只能有一個</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：C++ 類別特性</h4>
                        <ul>
                            <li><strong>(A) 類別可以實現 c++物件導向的特性：</strong> 正確。類別是 C++ 實現封裝、繼承和多型等物件導向特性的基礎。</li>
                            <li><strong>(B) 一個類別只能產生一個物件實例：</strong> 錯誤。類別是模板，可以根據這個模板創建任意多個物件實例。例如，<code>class Car { ... }; Car myCar1, myCar2;</code> 這裡 <code>myCar1</code> 和 <code>myCar2</code> 都是 <code>Car</code> 類別的物件實例。</li>
                            <li><strong>(C) 類別的建構子可以重載：</strong> 正確。建構子 (constructor) 是特殊的成員函式，用於初始化物件。C++ 允許函式重載 (overloading)，只要參數列表不同，就可以有多個同名建構子。</li>
                            <li><strong>(D) 類別的解構子只能有一個：</strong> 正確。解構子 (destructor) 是特殊的成員函式，在物件生命週期結束時被呼叫 (例如，釋放資源)。解構子的名稱是 <code>~ClassName()</code>，它不能有參數，也不能被重載，因此每個類別只能有一個解構子。</li>
                        </ul>
                        <h4>✓ 正確答案</h4> <p>本題的正確答案是： (B)</p>
                    </div>
                    <div class="next-btn-container"><button class="next-btn" data-target="#q3">下一題</button></div>
                </div>

                <!-- ... باقي البطاقات ... -->

                <div id="q33" class="quiz-card">
                    <h3>33. (原 第二個 Q32) 下列程式片段為計算管道內水流量的全域類別，其中 TotalFlow()為計算流量值的成員函式。若要在 main 主程式內使用 T1 或 T2 物件來編寫程式，下列程式敘述何者正確？</h3>
                    <pre><code class="language-cpp">#include &lt;iostream&gt; // For std::cout in example
enum Item{_FlowRate_Q33, _Time_Q33 };
class Volume {
private:
    double FlowRate, Time;
public:
    static double Offset;
    Volume (){ FlowRate =0.0; Time = 0.0;}
    Volume (double In1, double In2) { FlowRate = In1; Time = In2; }
    void SetOffset(double offs) { Offset = offs; }
    double GetParameter(Item item) { return (item == _Time_Q33) ? Time : FlowRate ;}
    void SetPara(double FR,double T) { FlowRate =FR; Time = T;}
protected:
    double TotalFlow(){return FlowRate*Time;}
public:
    double GetTotalFlow() { return TotalFlow(); } // Public wrapper for protected member
};
double Volume::Offset = 0.0;
Volume T1(1.0,2.3), T2; // Global objects
                    </code></pre>
                    <button class="run-example-btn" data-code-id="q33-code">運行示例</button>
                    <div class="quiz-options" data-correct="D">
                        <div class="option" data-option="A">(A) double Value1 = T1 – &gt; GetParameter (_Time);</div>
                        <div class="option" data-option="B">(B) T1 – &gt; SetPara (100.5,50);</div>
                        <div class="option" data-option="C">(C) T2.FlowRate = 12.4;</div>
                        <div class="option" data-option="D">(D) T2.SetOffset (–3.2);</div>
                    </div>
                    <div class="explanation">
                        <h4>✓ 解題思路：類別成員存取與靜態成員</h4>
                        <p>分析類別 <code>Volume</code> 和物件 <code>T1</code>, <code>T2</code>：</p>
                        <ul>
                            <li><code>FlowRate</code>, <code>Time</code>: private 成員變數。</li>
                            <li><code>Offset</code>: public static 成員變數。所有 <code>Volume</code> 物件共享同一個 <code>Offset</code>。</li>
                            <li><code>SetOffset(double)</code>: public 成員函式，設定靜態成員 <code>Offset</code>。</li>
                            <li><code>GetParameter(Item)</code>: public 成員函式。</li>
                            <li><code>SetPara(double, double)</code>: public 成員函式。</li>
                            <li><code>TotalFlow()</code>: protected 成員函式。不能直接從 <code>main</code> (類別外部) 存取。</li>
                            <li><code>T1</code>, <code>T2</code>: <code>Volume</code> 類別的物件。<code>T1</code> 初始化 <code>FlowRate=1.0, Time=2.3</code>。<code>T2</code> 使用預設建構子初始化 <code>FlowRate=0.0, Time=0.0</code>。</li>
                        </ul>
                        <p>分析選項：</p>
                        <ul>
                            <li><strong>(A) <code>double Value1 = T1 – &gt; GetParameter (_Time);</code></strong>：錯誤。<code>T1</code> 是一個物件實例，不是指標。應使用 <code>.</code> 運算子：<code>T1.GetParameter(_Time_Q33)</code>。<code>– &gt;</code> 是用於透過物件指標存取成員。</li>
                            <li><strong>(B) <code>T1 – &gt; SetPara (100.5,50);</code></strong>：錯誤。同上，<code>T1</code> 是物件實例，應使用 <code>.</code> 運算子：<code>T1.SetPara(100.5, 50)</code>。</li>
                            <li><strong>(C) <code>T2.FlowRate = 12.4;</code></strong>：錯誤。<code>FlowRate</code> 是 <code>private</code> 成員，不能從類別外部 (如 <code>main</code>) 直接存取。應透過 public 成員函式 (如 <code>SetPara</code>) 來修改。</li>
                            <li><strong>(D) <code>T2.SetOffset (–3.2);</code></strong>：正確。<code>SetOffset</code> 是 public 成員函式，可以用物件實例 <code>T2</code> 呼叫。它會修改靜態成員 <code>Offset</code>。</li>
                        </ul>
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
                    <h3>C++/C 語言程式碼沙箱 (WASM)</h3>
                    <textarea id="code-editor" spellcheck="false">/* Default code will be loaded here by JavaScript */</textarea>
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
                'q5-code': '#include <iostream>\nstruct box { int hight, length, width; };\nint main() {\n    std::cout << "Size of int: " << sizeof(int) << " bytes\\n";\n    std::cout << "Size of box: " << sizeof(box) << " bytes (typically 3 * sizeof(int))\\n";\n    struct box a, b;\n    a.width = 50; b = a;\n    std::cout << "b.width: " << b.width << std::endl;\n    return 0;\n}',
                'q8-code': '#include <iostream>\nstruct item { int x, y; };\nint main() {\n    struct item items[10];\n    for (int i = 0; i < 10; i++) { items[i].x = i / 2; items[i].y = i % 2; }\n    std::cout << "items[9].x + items[9].y = " << items[9].x + items[9].y << std::endl;\n    std::cout << "Size of item: " << sizeof(item) << " bytes\\n";\n    std::cout << "Size of items array: " << sizeof(items) << " bytes\\n";\n    return 0;\n}',
                'q11-code': '#include <iostream>\nstruct tree { int x; int y; };\nint main() {\n    struct tree t;\n    struct tree *p;\n    p = &t;\n    t.x = 10; t.y = 20;\n    std::cout << "p->x: " << p->x << std::endl;\n    std::cout << "(*p).x: " << (*p).x << std::endl;\n    std::cout << "t.x: " << t.x << std::endl;\n    std::cout << "t->x would be a compile error." << std::endl;\n    return 0;\n}',
                'q14-code': '#include <iostream>\nstruct beta { int x, y, z; };\nint main() {\n    struct beta a, b;\n    struct beta *p, *q;\n    p = &a;\n    q = &b;\n    (*p).x = 10; (*p).y = 20; (*p).z = 30;\n    q = p;\n    std::cout << q->x + q->y + q->z << std::endl;\n    return 0;\n}',
                'q15-code': '#include <iostream>\nstruct CAT { int a, b; };\nvoid callCAT(struct CAT *pCAT) { pCAT->a = 100; pCAT->b = pCAT->a; }\nint main() {\n    struct CAT c;\n    struct CAT *p;\n    p = &c;\n    p->a = 50;\n    callCAT(p);\n    std::cout << p->b << std::endl;\n    return 0;\n}',
                'q20-code': '#include <iostream>\nclass box {\nprivate: int x, y;\npublic:\n    box() { this->x = 10; this->y = 10; std::cout << "Default constructor: x=" << x << ", y=" << y << std::endl;}\n    box(int x_val, int y_val) { this->x = x_val; this->y = y_val; std::cout << "Param constructor: x=" << x << ", y=" << y << std::endl;}\n    void print() { std::cout << "Box values: x=" << x << ", y=" << y << std::endl; }\n};\nint main() {\n    box b1;\n    box b2(5,15);\n    b1.print();\n    b2.print();\n    return 0;\n}',
                'q27-code': '#include <iostream>\n#include <vector>\nclass model {\nprivate: int val[5];\npublic:\n    void setNum(int i, int num) { if(i>=0 && i<5) val[i] = num; }\n    int getNum(int i) { if(i>=0 && i<5) return val[i]; return -1; }\n};\nint main() {\n    model m;\n    for (int i = 0; i < 5; i++) { m.setNum(i, i); }\n    std::cout << m.getNum(4) << std::endl;\n    return 0;\n}',
                'q29-code': '#include <iostream>\nclass CalculateArea {\nprivate: double Length, Width, Area;\npublic:\n    void SetPara(double, double);\n    double GetLength();\n    double GetWidth();\n    double GetArea();\n    CalculateArea() : Length(0), Width(0), Area(0) {}\n};\nvoid CalculateArea::SetPara(double L, double W) { Length = L; Width = W; Area = L * W; }\ndouble CalculateArea::GetLength() { return Length; }\ndouble CalculateArea::GetWidth() { return Width; }\ndouble CalculateArea::GetArea() { return Area; }\nint main() {\n    CalculateArea rect;\n    rect.SetPara(10.0, 5.0);\n    std::cout << "Length: " << rect.GetLength() << std::endl;\n    std::cout << "Width: " << rect.GetWidth() << std::endl;\n    std::cout << "Area: " << rect.GetArea() << std::endl;\n    return 0;\n}',
                'q31-code': '#include <stdio.h>\n#define N_Q31 50\ntypedef struct studentScore {\n    int id;\n    float score;\n} SCORE;\nint main(void) {\n    SCORE student[N_Q31], *p;\n    float sscore;\n    student[27].id = 12345;\n    student[27].score = 88.5f;\n    student[28].id = 67890;\n    student[28].score = 90.0f;\n    p = student+28;\n    sscore = student[27].score;\n    printf("Score of student at index 27 (ID %d): %.1f\\n", student[27].id, sscore);\n    printf("Score of student p points to (ID %d, index 28): %.1f\\n", p->id, p->score);\n    return 0;\n}',
                'q33-code': '#include <iostream>\n#include <vector>\n// Q33 is original second Q32\nenum Item_q33{_FlowRate_Q33, _Time_Q33 };\nclass Volume {\nprivate:\n    double FlowRate, Time;\npublic:\n    static double Offset;\n    Volume (){ FlowRate =0.0; Time = 0.0;}\n    Volume (double In1, double In2) { FlowRate = In1; Time = In2; }\n    void SetOffset(double offs) { Offset = offs; }\n    double GetParameter(Item_q33 item) { return (item == _Time_Q33) ? Time : FlowRate ;}\n    void SetPara(double FR,double T) { FlowRate =FR; Time = T;}\nprotected:\n    double TotalFlow(){return FlowRate*Time;}\npublic:\n    double GetTotalFlow() { return TotalFlow(); }\n};\ndouble Volume::Offset = 0.0;\nVolume T1_q33(1.0,2.3), T2_q33;\nint main() {\n    std::cout << "Initial T1.Offset: " << T1_q33.Offset << ", T2.Offset: " << T2_q33.Offset << std::endl;\n    T2_q33.SetOffset(0.5);\n    std::cout << "After T2.SetOffset(0.5): T1.Offset: " << T1_q33.Offset << ", T2.Offset: " << T2_q33.Offset << std::endl;\n    T1_q33.SetOffset(0.0); // Reset for next test\n    T2_q33.SetOffset(-3.2); // Option (D) from original question\n    std::cout << "After T2.SetOffset(-3.2), T1.Offset is: " << Volume::Offset << std::endl;\n    // Test other options for completeness of example\n    // T1_q33.SetPara(100.5,50);\n    // std::cout << "T1 FlowRate after SetPara: " << T1_q33.GetParameter(_FlowRate_Q33) << std::endl;\n    // T2_q33.FlowRate = 12.4; // Compile error: FlowRate is private\n    return 0;\n}'
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

            if (codeSamples['q5-code']) { // Q5 is the first with a code sample in this set
                 codeEditor.value = codeSamples['q5-code'];
            } else if (Object.keys(codeSamples).length > 0) {
                 codeEditor.value = codeSamples[Object.keys(codeSamples)[0]];
            } else {
                 codeEditor.value = "// Welcome! No runnable examples in this section. Write your own C++/C code here.";
            }
        });
    </script>
</body>
</html>
