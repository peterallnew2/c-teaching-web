<?php
header('Content-Type: text/html; charset=utf-8');

// EE7-6 Quiz Data - 28 Object-Oriented Questions
// Data meticulously re-checked to ensure code in question_text is wrapped in <pre><code class="language-cpp">...</code></pre>
// and newlines within that code are '\\n' literals.
$current_exercises = [
    [
        'id_suffix' => '1',
        'question_text' => '1. 關於 C++語言的結構(struct)和類別(class)，下列哪一個敘述正確？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A) C++是物件導向語言，使用類別來定義資料和操作資料的方法'],
            ['key' => 'B', 'text' => '(B) 結構是使用者自已建立的資料型態，包含多個成員'],
            ['key' => 'C', 'text' => '(C) 一個類別可以有多個物件的實作'],
            ['key' => 'D', 'text' => '(D) 以上皆是'],
        ],
        'correct_answer' => 'D',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：C++ 結構 (struct) 與類別 (class)</strong></p>
<ul>
    <li><strong>類別 (Class)：</strong> 是C++物件導向程式設計的核心。它是一個藍圖，用於定義物件的屬性 (資料成員) 和行為 (成員函式/方法)。C++ 使用類別來實現封裝、繼承和多型等物件導向特性。</li>
    <li><strong>結構 (Struct)：</strong> 在C++中，結構與類別非常相似。主要的預設差異在於成員的存取權限：
        <ul>
            <li><code>struct</code> 的成員預設是 <code>public</code>。</li>
            <li><code>class</code> 的成員預設是 <code>private</code>。</li>
        </ul>
        除此之外，<code>struct</code> 也可以有成員函式、建構子、解構子，並且可以參與繼承。結構本質上也是一種使用者自訂的資料型態，可以將多個不同型別的資料組合成一個單元。
    </li>
    <li><strong>物件 (Object)：</strong> 是類別的一個實例 (instance)。一個類別定義了物件的規格，而程式可以根據這個規格創建多個具有相同結構和行為的物件。</li>
</ul>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) C++是物件導向語言，使用類別來定義資料和操作資料的方法：</strong>正確。這是C++作為物件導向語言的基本特徵，類別是定義物件藍圖的方式，包含資料 (attributes) 和方法 (behaviors)。</li>
    <li><strong>(B) 結構是使用者自已建立的資料型態，包含多個成員：</strong>正確。結構允許使用者將不同型別的資料組合成一個新的、自訂的資料型態。</li>
    <li><strong>(C) 一個類別可以有多個物件的實作：</strong>正確。類別是模板，可以根據這個模板創建任意數量的物件實例。例如，可以有一個 <code>Car</code> 類別，然後創建多個 <code>Car</code> 物件，如 <code>myCar</code>, <code>yourCar</code>。</li>
    <li><strong>(D) 以上皆是：</strong>因為 (A), (B), (C) 都正確，所以此選項正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>所有敘述都是正確的。</p>
HTML
    ],
    [
        'id_suffix' => '2',
        'question_text' => '2. 有關 C++語言的類別描述，下列何者錯誤？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A) 類別可以實現 C++物件導向的特性'],
            ['key' => 'B', 'text' => '(B) 一個類別只能產生一個物件實例'],
            ['key' => 'C', 'text' => '(C) 類別的建構子可以重載'],
            ['key' => 'D', 'text' => '(D) 類別的解構子只能有一個'],
        ],
        'correct_answer' => 'B',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：C++ 類別特性</strong></p>
<ul>
    <li><strong>物件導向特性：</strong>類別是C++實現物件導向三大特性 (封裝、繼承、多型) 的基礎。</li>
    <li><strong>物件實例：</strong>一個類別是創建物件的模板。根據一個類別，可以創建任意多個物件實例。例如，<code>class Dog {...}; Dog dog1, dog2, dog3;</code> 這樣就從 <code>Dog</code> 類別產生了三個物件實例。</li>
    <li><strong>建構子 (Constructor)：</strong>是一種特殊的成員函式，在創建類別的物件時自動被呼叫，主要用於初始化物件的資料成員。
        <ul>
            <li>建構子的名稱與類別名稱完全相同。</li>
            <li>建構子沒有回傳型別 (連 <code>void</code> 都不寫)。</li>
            <li>一個類別可以有多個建構子，只要它們的參數列表不同 (個數、型態、順序不同)，這稱為<strong>建構子重載 (overloading)</strong>。</li>
        </ul>
    </li>
    <li><strong>解構子 (Destructor)：</strong>也是一種特殊的成員函式，在物件的生命週期結束時 (例如，物件離開其作用域或被 <code>delete</code> 刪除時) 自動被呼叫，主要用於釋放物件在建構時可能獲取的資源 (如動態分配的記憶體)。
        <ul>
            <li>解構子的名稱是在類別名稱前加上波浪號 <code>~</code> (例如 <code>~MyClass()</code>)。</li>
            <li>解構子沒有回傳型別，也沒有參數。</li>
            <li>一個類別<strong>只能有一個解構子</strong>。解構子不能被重載。</li>
        </ul>
    </li>
</ul>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) 類別可以實現 C++物件導向的特性：</strong>正確。類別是實現封裝、繼承、多型的基礎。</li>
    <li><strong>(B) 一個類別只能產生一個物件實例：</strong>錯誤。一個類別是藍圖，可以根據這個藍圖創建任意數量的物件實例。如果一個類別只能產生一個物件，那通常是透過設計模式 (如單例模式 Singleton Pattern) 來刻意限制的，而非類別本身的固有特性。</li>
    <li><strong>(C) 類別的建構子可以重載：</strong>正確。只要參數列表不同，一個類別可以有多個建構子。</li>
    <li><strong>(D) 類別的解構子只能有一個：</strong>正確。解構子不能有參數，因此不能被重載，每個類別最多只有一個解構子。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>敘述「(B) 一個類別只能產生一個物件實例」是錯誤的。</p>
HTML
    ],
    [
        'id_suffix' => '3',
        'question_text' => '3. 有關 C++語言的物件導向功能，下列何者正確？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A) C 語言繼承 C++語言，所以 C 語言也是物件導向語言'],
            ['key' => 'B', 'text' => '(B) 使用「..」表示類別之間的繼承關係'],
            ['key' => 'C', 'text' => '(C) 一個子類別可以繼承多個父類別'],
            ['key' => 'D', 'text' => '(D) 類別就是物件的實作'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：C++ 物件導向特性</strong></p>
<ul>
    <li><strong>C 與 C++ 的關係：</strong>C++ 是在 C 語言的基礎上發展起來的，它擴展了 C 語言並增加了物件導向的特性。C 語言本身是一種程序導向 (procedural) 語言，不直接支援物件導向的核心概念如類別、繼承和多型。所以 C++ 繼承並擴展了 C，而不是反過來。</li>
    <li><strong>繼承語法：</strong>在 C++ 中，表示類別之間的繼承關係使用冒號 <code>:</code>，後面跟著存取修飾詞 (如 <code>public</code>, <code>protected</code>, <code>private</code>) 和父類別的名稱。例如：<code>class DerivedClass : public BaseClass { ... };</code>。</li>
    <li><strong>多重繼承 (Multiple Inheritance)：</strong>C++ 語言支援多重繼承，這意味著一個子類別 (derived class) 可以同時繼承自多個父類別 (base classes)。語法如：<code>class Child : public Parent1, public Parent2 { ... };</code>。</li>
    <li><strong>類別與物件：</strong>
        <ul>
            <li><strong>類別 (Class)：</strong>是一個藍圖、模板或定義。它描述了一類物件共同具有的屬性 (資料成員) 和行為 (成員函式)。類別本身不是一個具體的實體。</li>
            <li><strong>物件 (Object)：</strong>是類別的一個具體實例 (instance)。物件是根據類別的定義在記憶體中創建的實體。可以說，物件是類別的「實作」或「實例化」。</li>
        </ul>
    </li>
</ul>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) C 語言繼承 C++語言，所以 C 語言也是物件導向語言：</strong>錯誤。C++ 是基於 C 發展並增加了物件導向特性。C 語言本身不是物件導向語言。</li>
    <li><strong>(B) 使用「..」表示類別之間的繼承關係：</strong>錯誤。C++ 使用冒號 <code>:</code> 來表示繼承關係。<code>..</code> 運算子通常用於範圍解析 (scope resolution operator 是 <code>::</code>) 或其他語言的特定語法，與 C++ 繼承無關。</li>
    <li><strong>(C) 一個子類別可以繼承多個父類別：</strong>正確。這是 C++ 的多重繼承特性。</li>
    <li><strong>(D) 類別就是物件的實作：</strong>這個說法不夠精確，容易混淆。更準確地說，物件是類別的實作 (或實例)。類別是定義，物件是根據該定義創建的實體。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>敘述「(C) 一個子類別可以繼承多個父類別」是正確的，描述了 C++ 的多重繼承能力。</p>
HTML
    ],
    [
        'id_suffix' => '4',
        'question_text' => '4. 一程式片段如下，關於程式碼的說明，何者錯誤？<pre><code class="language-cpp">class I : public J { public: void beep(); };</code></pre>',
        'code_snippet' => null, // Code is in question_text
        'run_code_id' => 'q4-code',
        'code_snippet_for_runner' => "#include <iostream>\n\nclass J {\npublic:\n    int j_public_var = 10;\n    void j_public_method() {\n        std::cout << \"J's public method called.\\n\";\n    }\nprotected:\n    int j_protected_var = 20;\nprivate:\n    int j_private_var = 30;\n};\n\nclass I : public J {\npublic:\n    void beep() {\n        std::cout << \"I's beep method called.\\n\";\n        std::cout << \"Accessing J's public_var from I: \" << j_public_var << std::endl;\n        std::cout << \"Accessing J's protected_var from I: \" << j_protected_var << std::endl;\n    }\n    void access_j_method() {\n        j_public_method(); \n    }\n};\n\nint main() {\n    I i_obj;\n    i_obj.beep();\n    i_obj.access_j_method();\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A) I 類別繼承 J 類別'],
            ['key' => 'B', 'text' => '(B) I 類別會擁有 J 類別的公有成員'],
            ['key' => 'C', 'text' => '(C) J 類別擁有 beep( )成員函式'],
            ['key' => 'D', 'text' => '(D) I 和 J 是物件導向的繼承關係'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：C++ 類別繼承</strong></p>
<p>程式碼片段 <code>class I : public J { public: void beep(); };</code> 描述了類別繼承關係。</p>
<ul>
    <li><strong><code>class I : public J</code>：</strong>這表示類別 <code>I</code> 公開繼承 (publicly inherits) 自類別 <code>J</code>。
        <ul>
            <li><code>I</code> 被稱為子類別 (derived class 或 child class)。</li>
            <li><code>J</code> 被稱為父類別 (base class 或 parent class)。</li>
        </ul>
    </li>
    <li><strong>公開繼承 (<code>public J</code>)：</strong>
        <ul>
            <li>父類別 <code>J</code> 的 <code>public</code> 成員在子類別 <code>I</code> 中仍然是 <code>public</code>。</li>
            <li>父類別 <code>J</code> 的 <code>protected</code> 成員在子類別 <code>I</code> 中變成 <code>protected</code>。</li>
            <li>父類別 <code>J</code> 的 <code>private</code> 成員對子類別 <code>I</code> 是不可直接存取的 (但它們仍然是子類別物件的一部分)。</li>
        </ul>
        因此，子類別 <code>I</code> "擁有" (繼承了) 父類別 <code>J</code> 的公有 (public) 和保護 (protected) 成員。
    </li>
    <li><strong><code>public: void beep();</code>：</strong>這是在子類別 <code>I</code> 中宣告了一個名為 <code>beep</code> 的公有成員函式。這個函式是類別 <code>I</code> 特有的 (或可能是對父類別中同名函式的覆寫，但題目未提供 <code>J</code> 的定義)。</li>
</ul>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) I 類別繼承 J 類別：</strong>正確。語法 <code>class I : public J</code> 明確表示 <code>I</code> 繼承自 <code>J</code>。</li>
    <li><strong>(B) I 類別會擁有 J 類別的公有成員：</strong>正確。由於是公開繼承，<code>J</code> 的公有成員會成為 <code>I</code> 的公有成員，<code>J</code> 的保護成員會成為 <code>I</code> 的保護成員。所以 <code>I</code> 確實 "擁有" (可以存取和使用) <code>J</code> 的公有成員。</li>
    <li><strong>(C) J 類別擁有 beep( )成員函式：</strong>錯誤。<code>beep()</code> 函式是在類別 <code>I</code> 的定義中宣告的，因此它是類別 <code>I</code> 的成員函式。除非類別 <code>J</code> 自身也定義了一個名為 <code>beep</code> 的函式 (題目未顯示)，否則不能說 <code>J</code> 擁有這個在 <code>I</code> 中定義的 <code>beep()</code>。</li>
    <li><strong>(D) I 和 J 是物件導向的繼承關係：</strong>正確。這正是程式碼所展示的。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>敘述「(C) J 類別擁有 beep( )成員函式」是錯誤的。<code>beep()</code> 是在 <code>I</code> 類別中定義的。</p>
HTML
    ],
    [
        'id_suffix' => '5',
        'question_text' => '5. 小雪在 C/C++語言中宣告一個結構 box，程式碼如下，請問該結構會佔用多少的記憶體空間？<pre><code class="language-c">struct box{\\n    int hight, length, width;\\n};</code></pre>',
        'code_snippet' => null, // Code is in question_text
        'run_code_id' => 'q5-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\nstruct box{\n    int hight, length, width;\n};\n\nint main() {\n    printf(\"Size of int: %zu bytes\\n\", sizeof(int));\n    printf(\"Size of struct box: %zu bytes\\n\", sizeof(struct box));\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A)3Byte'],
            ['key' => 'B', 'text' => '(B)12Byte'],
            ['key' => 'C', 'text' => '(C)24Byte'],
            ['key' => 'D', 'text' => '(D)48Byte'],
        ],
        'correct_answer' => 'B',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：結構 (struct) 的記憶體大小與 <code>sizeof</code></strong></p>
<p>結構 (<code>struct</code>) 是一種使用者自訂的資料型態，它可以將多個不同型別的資料成員組合成一個單一的單元。</p>
<p>結構所佔用的總記憶體空間通常是其所有成員大小的總和。然而，由於<strong>記憶體對齊 (memory alignment)</strong> 的要求，編譯器有時可能會在成員之間或結構末尾插入一些額外的填充位元組 (padding bytes)，以確保每個成員都位於適合其型態的記憶體位址上，從而提高存取效率。</p>
<p>對於這個特定的結構：</p>
<pre><code class="language-c">
struct box{
    int hight;
    int length;
    int width;
};
</code></pre>
<ul>
    <li>它包含三個 <code>int</code> 型別的成員：<code>hight</code>, <code>length</code>, <code>width</code>。</li>
    <li>在大多數現代系統上，一個 <code>int</code> 型別通常佔用 4 bytes。</li>
</ul>
<p>如果沒有記憶體對齊的填充，該結構的大小將是：<br>
Size = sizeof(hight) + sizeof(length) + sizeof(width)<br>
Size = sizeof(int) + sizeof(int) + sizeof(int)<br>
Size = 4 bytes + 4 bytes + 4 bytes = 12 bytes。</p>
<p>由於所有成員都是 <code>int</code> 型別，它們通常具有相同的對齊要求 (例如，4位元組對齊)，並且它們可以連續排列而不需要額外的填充位元組。</p>
<p><strong>2. 選項分析 (假設 <code>int</code> 為 4 bytes)：</strong></p>
<ul>
    <li><strong>(A) 3Byte：</strong>太小了，一個 <code>int</code> 通常就比這大。</li>
    <li><strong>(B) 12Byte：</strong>這是 3 個 4-byte <code>int</code> 成員的總和 (3 * 4 = 12)。這在沒有額外填充的情況下是正確的。</li>
    <li><strong>(C) 24Byte：</strong>太大，除非 <code>int</code> 是 8 bytes (不常見，通常 <code>long long</code> 才是)。</li>
    <li><strong>(D) 48Byte：</strong>遠大於預期。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>假設在一個 <code>int</code> 型別佔用 4 bytes 的常見系統中，並且沒有因特殊對齊需求而產生額外填充，<code>struct box</code> 將佔用 12 bytes 的記憶體空間。</p>
HTML
    ],
    [
        'id_suffix' => '6',
        'question_text' => '6. 承上題，使用 box 結構宣告 a 和 b 兩個結構變數，何者才是正確的語法？',
        'code_snippet' => "// struct box{\\n// int hight, length, width;\\n// };",
        'run_code_id' => 'q6-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\nstruct box{\n    int hight, length, width;\n};\n\nint main() {\n    struct box a, b; // Correct declaration\n    a.hight = 10;\n    b.width = 20;\n    printf(\"a.hight = %d\\n\", a.hight);\n    printf(\"b.width = %d\\n\", b.width);\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A) a=struct(box)， b=struct(box)，'],
            ['key' => 'B', 'text' => '(B) struct box a， b，'],
            ['key' => 'C', 'text' => '(C) box struct a， b，'],
            ['key' => 'D', 'text' => '(D) #struct box a<br>#struct box b'],
        ],
        'correct_answer' => 'B',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：C/C++ 結構變數的宣告</strong></p>
<p>在 C 和 C++ 中，一旦定義了一個結構型態，就可以使用該型態來宣告變數。</p>
<p>假設我們有以下結構定義 (來自上一題)：</p>
<pre><code class="language-c">
struct box {
    int hight, length, width;
};
</code></pre>
<p>宣告該結構型態的變數的語法是：</p>
<p><code>struct <結構名稱> <變數名1>, <變數名2>, ...;</code></p>
<p>所以，要宣告兩個名為 <code>a</code> 和 <code>b</code> 的 <code>box</code> 結構變數，正確的語法是：</p>
<p><code>struct box a, b;</code></p>
<p>或者可以分開宣告：</p>
<p><code>struct box a;</code><br>
<code>struct box b;</code></p>
<p><strong>在 C++ 中，</strong> 一旦結構 (或類別) 被定義，你也可以省略 <code>struct</code> (或 <code>class</code>) 關鍵字來宣告變數，直接使用結構名作為型態名：</p>
<p><code>box a, b; // C++ only, after struct box is defined</code></p>
<p>然而，題目中的選項更偏向 C 語言的傳統風格，並且選項 (B) 是 C 和 C++ 都完全正確的語法。</p>
<p><strong>2. 選項分析：</strong></p>
<p>注意：選項中的逗號 <code>，</code> 應為半形 <code>,</code>。</p>
<ul>
    <li><strong>(A) <code>a=struct(box)， b=struct(box)，</code>：</strong>這是錯誤的語法。<code>struct(box)</code> 不是一個有效的型態轉換或賦值語法。變數宣告不使用賦值符號來指定型態。</li>
    <li><strong>(B) <code>struct box a， b，</code> (應為 <code>struct box a, b;</code>)：</strong>這是正確的 C/C++ 語法，用於宣告兩個 <code>struct box</code> 型態的變數 <code>a</code> 和 <code>b</code> (忽略行末多餘的逗號)。</li>
    <li><strong>(C) <code>box struct a， b，</code>：</strong>這是錯誤的語法。<code>struct</code> 關鍵字應該在結構名稱之前。</li>
    <li><strong>(D) <code>#struct box a</code><br><code>#struct box b</code>：</strong>這是錯誤的語法。<code>#</code> 符號在 C/C++ 中用於前置處理指令 (如 <code>#include</code>, <code>#define</code>)，不適用於變數宣告。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>選項 (B) <code>struct box a, b;</code> (修正標點後) 是宣告結構變數 <code>a</code> 和 <code>b</code> 的正確語法。</p>
HTML
    ],
    [
        'id_suffix' => '7',
        'question_text' => '7. 承上題，完成結構變數 a 和 b 的宣告後，執行下列程式片段的輸出為何？<pre><code class="language-cpp">a.width = 50;\\nb = a;\\ncout << b.width;</code></pre>',
        'code_snippet' => null, // Code is in question_text
        'run_code_id' => 'q7-code',
        'code_snippet_for_runner' => "#include <iostream>\n\nstruct box{\n    int hight, length, width;\n};\n\nint main() {\n    struct box a, b;\n    a.hight = 10;\n    a.length = 20;\n    a.width = 50;\n\n    b = a; \n\n    std::cout << b.width << std::endl;\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A)50'],
            ['key' => 'B', 'text' => '(B)40'],
            ['key' => 'C', 'text' => '(C)30'],
            ['key' => 'D', 'text' => '(D)20'],
        ],
        'correct_answer' => 'A',
        'explanation_html' => <<<HTML
<h4>詳解 (C++/C Context)</h4>
<p><strong>1. 關鍵概念：結構賦值 (Structure Assignment)</strong></p>
<p>在 C 和 C++ 中，可以直接將一個結構變數的值賦給另一個相同型態的結構變數。這種賦值操作會執行<strong>成員對成員的複製 (memberwise copy)</strong>。也就是說，來源結構的每個成員的值都會被複製到目標結構的相應成員中。</p>
<p>假設結構 <code>box</code> 定義如下：</p>
<pre><code class="language-c">
struct box {
    int hight, length, width;
};
</code></pre>
<p>以及變數宣告：</p>
<pre><code class="language-c">
struct box a, b;
</code></pre>
<p><strong>2. 程式碼分析：</strong></p>
<ol>
    <li><strong><code>a.width = 50;</code></strong>
        <ul><li>將結構變數 <code>a</code> 的成員 <code>width</code> 設定為 50。</li></ul>
    </li>
    <li><strong><code>b = a;</code></strong>
        <ul><li>結構 <code>a</code> 的所有成員的值都會被複製到結構 <code>b</code> 的對應成員中。所以 <code>b.width</code> 會得到 <code>a.width</code> 的值 (50)。</li></ul>
    </li>
    <li><strong><code>cout &lt;&lt; b.width;</code> (題目使用 <code>cout</code>，暗示 C++ 環境)</strong>
        <ul><li>輸出結構變數 <code>b</code> 的成員 <code>width</code> 的值，即 50。</li></ul>
    </li>
</ol>
<p><strong>3. 選項分析：</strong></p>
<ul>
    <li><strong>(A) 50：</strong>正確。</li>
    <li><strong>(B) 40：</strong>錯誤。</li>
    <li><strong>(C) 30：</strong>錯誤。</li>
    <li><strong>(D) 20：</strong>錯誤。</li>
</ul>
<p><strong>4. 結論：</strong></p>
<p>執行完程式片段後，<code>b.width</code> 的值是 50，因此輸出為 50。</p>
HTML
    ],
    [
        'id_suffix' => '8',
        'question_text' => '8. 一程式片段如下，試問執行後的輸出為何？<pre><code class="language-cpp">struct item{\\n    int x, y;\\n};\\n\\nint main()\\n{\\n    struct item items[10];\\n    for (int i=0; i<10; i++){\\n        items[i].x = i / 2;\\n        items[i].y = i % 2;\\n    }\\n    std::cout << items[9].x + items[9].y << std::endl;\\n    return 0;\\n}</code></pre>',
        'code_snippet' => null, // Code is in question_text
        'run_code_id' => 'q8-code',
        'code_snippet_for_runner' => "#include <iostream>\n\nstruct item{\n    int x, y;\n};\n\nint main()\n{\n    struct item items[10];\n    for (int i=0; i<10; i++){\n        items[i].x = i / 2;\n        items[i].y = i % 2;\n    }\n    std::cout << items[9].x + items[9].y << std::endl;\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A)3'],
            ['key' => 'B', 'text' => '(B)4'],
            ['key' => 'C', 'text' => '(C)5'],
            ['key' => 'D', 'text' => '(D)6'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：結構陣列、整數除法、模除運算子</strong></p>
<ul>
    <li><strong>結構陣列：</strong><code>struct item items[10];</code> 宣告了一個包含 10 個 <code>struct item</code> 型態元素的陣列。</li>
    <li><strong>整數除法 (<code>/</code>)：</strong>結果會是商的整數部分，小數部分被捨棄 (e.g., <code>9 / 2 = 4</code>)。</li>
    <li><strong>模除運算子 (<code>%</code>)：</strong>回傳兩個整數相除後的餘數 (e.g., <code>9 % 2 = 1</code>)。</li>
</ul>
<p><strong>2. 程式碼追蹤：</strong></p>
<p>我們關心 <code>i = 9</code> 時：</p>
<ul>
    <li><code>items[9].x = 9 / 2;</code>  結果 <code>items[9].x = 4</code>。</li>
    <li><code>items[9].y = 9 % 2;</code>  結果 <code>items[9].y = 1</code>。</li>
</ul>
<p>最後輸出 <code>items[9].x + items[9].y</code>，即 <code>4 + 1 = 5</code>。</p>
<p><strong>3. 選項分析：</strong></p>
<ul>
    <li>(C) 5：正確。</li>
</ul>
<p><strong>4. 結論：</strong></p>
<p>程式執行後的輸出為 5。</p>
HTML
    ],
    [
        'id_suffix' => '9',
        'question_text' => '9. 承上題，結構陣列 items[ ]會用掉幾 Bytes 的記憶體空間？',
        'code_snippet' => "// struct item{ int x, y; };\n// struct item items[10];",
        'run_code_id' => 'q9-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\nstruct item{\n    int x, y;\n};\n\nint main() {\n    struct item items[10];\n    printf(\"Size of int: %zu bytes\\n\", sizeof(int));\n    printf(\"Size of one struct item: %zu bytes\\n\", sizeof(struct item));\n    printf(\"Size of items array (10 elements): %zu bytes\\n\", sizeof(items));\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A)40'],
            ['key' => 'B', 'text' => '(B)60'],
            ['key' => 'C', 'text' => '(C)80'],
            ['key' => 'D', 'text' => '(D)120'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：結構陣列的記憶體大小</strong></p>
<p>結構 <code>item</code> 定義為 <code>struct item { int x; int y; };</code>。它包含兩個 <code>int</code> 成員。</p>
<p>假設一個 <code>int</code> 佔用 4 bytes (常見情況)。則一個 <code>struct item</code> 的大小為 <code>sizeof(int) + sizeof(int) = 4 + 4 = 8 bytes</code> (通常沒有填充)。</p>
<p>結構陣列 <code>items[10]</code> 包含 10 個這樣的元素。</p>
<p><strong>2. 計算總記憶體空間：</strong></p>
<p>總大小 = (單個元素大小) × (元素數量) = 8 bytes/element × 10 elements = 80 bytes。</p>
<p><strong>3. 選項分析：</strong></p>
<ul>
    <li>(C) 80：正確。</li>
</ul>
<p><strong>4. 結論：</strong></p>
<p>結構陣列 <code>items[10]</code> 將用掉 80 Bytes 的記憶體空間 (假設 <code>int</code> 為 4 bytes)。</p>
HTML
    ],
    [
        'id_suffix' => '10',
        'question_text' => '10. 函式 setValue( )的原型宣告如下，現有一 IOT 結構的結構變數 thing，下列何者是呼叫該函式的正確語法？<pre><code class="language-c">void setValue(struct IOT*);</code></pre>',
        'code_snippet' => null, // Code is in question_text
        'run_code_id' => 'q10-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\nstruct IOT {\n    int data;\n};\n\nvoid setValue(struct IOT* ptr_iot) {\n    if (ptr_iot != NULL) {\n        ptr_iot->data = 100;\n        printf(\"Inside setValue: thing.data set to %d\\n\", ptr_iot->data);\n    }\n}\n\nint main() {\n    struct IOT thing;\n    thing.data = 0;\n    printf(\"Before setValue: thing.data = %d\\n\", thing.data);\n    setValue(&thing);\n    printf(\"After setValue: thing.data = %d\\n\", thing.data);\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A)setValue(thing)，'],
            ['key' => 'B', 'text' => '(B)setValue(＆thing)，'],
            ['key' => 'C', 'text' => '(C)setValue(＊thing)，'],
            ['key' => 'D', 'text' => '(D)setValue(IOT(thing))，'],
        ],
        'correct_answer' => 'B',
        'explanation_html' => <<<HTML
<h4>詳解 (C/C++ Context)</h4>
<p><strong>1. 關鍵概念：函式參數傳遞 - 傳址 (Pass by Address/Pointer)</strong></p>
<p>函式原型 <code>void setValue(struct IOT*);</code> 表示函式 <code>setValue</code> 接受一個指向 <code>struct IOT</code> 型別變數的指標作為參數。</p>
<p>當呼叫此函式並傳遞 <code>struct IOT thing;</code> 變數時，需要傳遞 <code>thing</code> 的記憶體位址，使用取址運算子 <code>&amp;</code>。</p>
<p><strong>2. 選項分析 (假設全形符號為筆誤)：</strong></p>
<ul>
    <li><strong>(A) <code>setValue(thing);</code>：</strong>錯誤。傳遞的是結構本身 (傳值)，而非指標。</li>
    <li><strong>(B) <code>setValue(&amp;thing);</code>：</strong>正確。<code>&amp;thing</code> 是 <code>thing</code> 的位址，型態為 <code>struct IOT*</code>，與函式參數型態匹配。</li>
    <li><strong>(C) <code>setValue(*thing);</code>：</strong>錯誤。<code>thing</code> 不是指標，對其解參考 (<code>*</code>) 無效。</li>
    <li><strong>(D) <code>setValue(IOT(thing));</code>：</strong>錯誤。這不是標準的 C/C++ 語法來傳遞指標。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>正確的呼叫語法是 <code>setValue(&amp;thing);</code>。</p>
HTML
    ],
    [
        'id_suffix' => '11',
        'question_text' => '11. 一程式片段如下，哪一個選項無法取得成員 x 的值？<pre><code class="language-c">struct tree{ int x; int y; };\\n\\nint main(){\\n    struct tree t;\\n    struct tree *p;\\n    p = &t;\\n}</code></pre>',
        'code_snippet' => null, // Code is in question_text
        'run_code_id' => 'q11-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\nstruct tree{\n    int x;\n    int y;\n};\n\nint main(){\n    struct tree t;\n    struct tree *p;\n    p = &t;\n    t.x = 100;\n    t.y = 200;\n    printf(\"Using t.x: %d\\n\", t.x);\n    printf(\"Using p->x: %d\\n\", p->x);\n    printf(\"Using (*p).x: %d\\n\", (*p).x);\n    // printf(\"Using t->x: %d\\n\", t->x); // This would cause a COMPILE ERROR\n    printf(\"Attempting t->x would cause a compile error.\\n\");\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A)t->x'],
            ['key' => 'B', 'text' => '(B)p->x'],
            ['key' => 'C', 'text' => '(C)(＊p).x'],
            ['key' => 'D', 'text' => '(D)t.x'],
        ],
        'correct_answer' => 'A',
        'explanation_html' => <<<HTML
<h4>詳解 (C/C++ Context)</h4>
<p><strong>1. 關鍵概念：存取結構成員</strong></p>
<ul>
    <li>透過結構變數：使用點運算子 (<code>.</code>)，例如 <code>t.x</code>。</li>
    <li>透過指向結構的指標：使用箭頭運算子 (<code>-&gt;</code>)，例如 <code>p-&gt;x</code>，或者解參考再用點運算子 <code>(*p).x</code>。</li>
</ul>
<p><strong>2. 程式碼分析：</strong></p>
<p><code>struct tree t;</code>：<code>t</code> 是一個結構變數。</p>
<p><code>struct tree *p; p = &amp;t;</code>：<code>p</code> 是一個指向結構 <code>t</code> 的指標。</p>
<p><strong>3. 選項分析：</strong></p>
<ul>
    <li><strong>(A) <code>t-&gt;x</code>：</strong>錯誤。<code>t</code> 是結構變數，不是指標。箭頭運算子 <code>-&gt;</code> 只能用於指標。</li>
    <li><strong>(B) <code>p-&gt;x</code>：</strong>正確。<code>p</code> 是指標，<code>p-&gt;x</code> 用於存取 <code>p</code> 所指向物件的成員 <code>x</code>。</li>
    <li><strong>(C) <code>(*p).x</code>：</strong>正確。<code>*p</code> 解參考指標得到結構物件 <code>t</code>，然後 <code>.x</code> 存取其成員。</li>
    <li><strong>(D) <code>t.x</code>：</strong>正確。<code>t</code> 是結構變數，<code>t.x</code> 直接存取其成員 <code>x</code>。</li>
</ul>
<p><strong>4. 結論：</strong></p>
<p>選項 (A) <code>t-&gt;x</code> 無法取得成員 <code>x</code> 的值，因為 <code>t</code> 不是指標。</p>
HTML
    ],
    [
        'id_suffix' => '12',
        'question_text' => '12. 有關 C 語言的結構(structure)，下列的說明何者錯誤？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)結構用來定義資料和資料的操作行為'],
            ['key' => 'B', 'text' => '(B)一個結構可以包含 1 個以上的成員'],
            ['key' => 'C', 'text' => '(C)使用「.」運算子存取結構成員'],
            ['key' => 'D', 'text' => '(D)結構陣列的每個元素，都是相同的結構'],
        ],
        'correct_answer' => 'A',
        'explanation_html' => <<<HTML
<h4>詳解 (C Context)</h4>
<p><strong>1. 關鍵概念：C 語言結構 (Structure)</strong></p>
<ul>
    <li>C 結構主要用於定義資料的集合和組織。</li>
    <li>資料的操作行為 (函式) 通常與結構分開定義，不像 C++ 類別那樣將資料和方法綁定。</li>
    <li>一個結構可以有一個或多個成員。</li>
    <li>使用點運算子 (<code>.</code>) 透過結構變數存取成員，或箭頭運算子 (<code>-&gt;</code>) 透過結構指標存取成員。</li>
    <li>結構陣列的元素都是相同的結構型態。</li>
</ul>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) 結構用來定義資料和資料的操作行為：</strong>錯誤。在 C 語言中，結構主要定義資料。操作行為由外部函式完成。此描述更符合 C++ 的類別。</li>
    <li><strong>(B) 一個結構可以包含 1 個以上的成員：</strong>正確。</li>
    <li><strong>(C) 使用「.」運算子存取結構成員：</strong>正確 (當直接使用結構變數時)。</li>
    <li><strong>(D) 結構陣列的每個元素，都是相同的結構：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>敘述「(A) 結構用來定義資料和資料的操作行為」對於 C 語言的結構而言是錯誤的。</p>
HTML
    ],
    [
        'id_suffix' => '13',
        'question_text' => '13. 下列有關 C/C++語言的敘述，何者是錯誤的？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)陣列是一個資料結構，可以存放多個相同資料型態的元素'],
            ['key' => 'B', 'text' => '(B)C++是物件導向語言，C 是程序導向語言'],
            ['key' => 'C', 'text' => '(C)C++支援函式重載(overload)，C   語言不支援'],
            ['key' => 'D', 'text' => '(D)自訂函式的回傳值型態為  null，表示函式沒有回傳值'],
        ],
        'correct_answer' => 'D',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：C/C++ 語言特性</strong></p>
<ul>
    <li><strong>陣列：</strong>存放多個相同型態元素的資料結構。</li>
    <li><strong>程式設計範式：</strong>C++ 支援 OOP，C 是程序導向。</li>
    <li><strong>函式重載：</strong>C++ 支援，C 不支援。</li>
    <li><strong>函式回傳型態：</strong>若函式不回傳值，其型態宣告為 <code>void</code>。<code>NULL</code> (或 <code>null</code>) 用於指標。</li>
</ul>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) 陣列是一個資料結構，可以存放多個相同資料型態的元素：</strong>正確。</li>
    <li><strong>(B) C++是物件導向語言，C 是程序導向語言：</strong>正確。</li>
    <li><strong>(C) C++支援函式重載(overload)，C 語言不支援：</strong>正確。</li>
    <li><strong>(D) 自訂函式的回傳值型態為 null，表示函式沒有回傳值：</strong>錯誤。應為 <code>void</code>。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>敘述「(D) 自訂函式的回傳值型態為 null，表示函式沒有回傳值」是錯誤的。</p>
HTML
    ],
    [
        'id_suffix' => '14',
        'question_text' => '14. 一程式片段如下，執行後的輸出為何？<pre><code class="language-cpp">struct beta{\\n    int x, y, z;\\n};\\n\\nint main(){\\n    struct beta a, b;\\n    struct beta *p, *q;\\n    p = &a;\\n    q = &b;\\n    (*p).x = 10;\\n    (*p).y = 20;\\n    (*p).z = 30;\\n    q=p;\\n    std::cout << q->x + q->y + q->z << std::endl;\\n}</code></pre>',
        'code_snippet' => null, // Code is in question_text
        'run_code_id' => 'q14-code',
        'code_snippet_for_runner' => "#include <iostream>\n\nstruct beta{\n    int x, y, z;\n};\n\nint main(){\n    struct beta a, b;\n    struct beta *p, *q;\n    p = &a;\n    q = &b;\n    (*p).x = 10;\n    (*p).y = 20;\n    (*p).z = 30;\n    q=p;\n    std::cout << q->x + q->y + q->z << std::endl;\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A)10'],
            ['key' => 'B', 'text' => '(B)20'],
            ['key' => 'C', 'text' => '(C)30'],
            ['key' => 'D', 'text' => '(D)60'],
        ],
        'correct_answer' => 'D',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：結構、指標、指標賦值</strong></p>
<p><strong>2. 程式碼執行追蹤：</strong></p>
<ol>
    <li><code>p = &amp;a; q = &amp;b;</code>：<code>p</code> 指向 <code>a</code>，<code>q</code> 指向 <code>b</code>。</li>
    <li><code>(*p).x = 10; (*p).y = 20; (*p).z = 30;</code>：結構 <code>a</code> 的成員被賦值 (<code>a.x=10, a.y=20, a.z=30</code>)。</li>
    <li><strong><code>q = p;</code></strong>：指標 <code>q</code> 現在也指向 <code>a</code>。</li>
    <li><code>std::cout &lt;&lt; q-&gt;x + q-&gt;y + q-&gt;z &lt;&lt; std::endl;</code>：因為 <code>q</code> 指向 <code>a</code>，所以輸出 <code>a.x + a.y + a.z</code>，即 <code>10 + 20 + 30 = 60</code>。</li>
</ol>
<p><strong>3. 結論：</strong></p>
<p>程式執行後的輸出為 60。</p>
HTML
    ],
    [
        'id_suffix' => '15',
        'question_text' => '15. 一程式片段如下，執行後的輸出為何？<pre><code class="language-cpp">struct  CAT{\\n    int a, b;\\n};\\n\\nvoid callCAT(struct CAT *pCAT){\\n    pCAT->a = 100;\\n    pCAT->b = pCAT->a;\\n}\\n\\nint main(){\\n    struct CAT c;\\n    struct CAT *p;\\n    p = &c;\\n    p->a = 50;\\n    callCAT(p);\\n    std::cout << p->b << std::endl;\\n}</code></pre>',
        'code_snippet' => null, // Code is in question_text
        'run_code_id' => 'q15-code',
        'code_snippet_for_runner' => "#include <iostream>\n\nstruct CAT{\n    int a, b;\n};\n\nvoid callCAT(struct CAT *pCAT){\n    pCAT->a = 100;\n    pCAT->b = pCAT->a;\n}\n\nint main(){\n    struct CAT c;\n    struct CAT *p;\n    p = &c;\n    p->a = 50;\n    callCAT(p);\n    std::cout << p->b << std::endl;\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A)10'],
            ['key' => 'B', 'text' => '(B)50'],
            ['key' => 'C', 'text' => '(C)100'],
            ['key' => 'D', 'text' => '(D)編譯錯誤'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：結構、指標、函式傳址呼叫</strong></p>
<p>函式 <code>callCAT</code> 接受一個指向 <code>CAT</code> 結構的指標。在函式內部修改指標所指向的結構的成員，會影響原始結構。</p>
<p><strong>2. 程式碼執行追蹤：</strong></p>
<ol>
    <li><code>struct CAT c; struct CAT *p; p = &c;</code>：指標 <code>p</code> 指向結構 <code>c</code>。</li>
    <li><code>p-&gt;a = 50;</code>：<code>c.a</code> 被設為 50。<code>c.b</code> 未初始化。</li>
    <li><code>callCAT(p);</code>：將 <code>c</code> 的位址傳給 <code>callCAT</code>。
        <ul>
            <li>在 <code>callCAT</code> 內：<code>pCAT</code> 指向 <code>c</code>。</li>
            <li><code>pCAT-&gt;a = 100;</code>：<code>c.a</code> 變為 100。</li>
            <li><code>pCAT-&gt;b = pCAT-&gt;a;</code>：<code>c.b</code> 變為 100 (因為 <code>c.a</code> 剛被設為 100)。</li>
        </ul>
    </li>
    <li><code>std::cout &lt;&lt; p-&gt;b &lt;&lt; std::endl;</code>：輸出 <code>c.b</code> 的值，即 100。</li>
</ol>
<p><strong>3. 結論：</strong></p>
<p>程式執行後的輸出為 100。</p>
HTML
    ],
    [
        'id_suffix' => '16',
        'question_text' => '16. 關於下列程式片段的描述，何者正確？<pre><code class="language-cpp">x = &y;\\nx->a = 1;</code></pre>',
        'code_snippet' => null, // Code is in question_text
        'run_code_id' => 'q16-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\nstruct MyStruct {\n    int a;\n    char b;\n};\n\nint main() {\n    struct MyStruct y;\n    struct MyStruct *x;\n    y.a = 0;\n    y.b = 'Z';\n    x = &y;\n    x->a = 1;\n    printf(\"y.a = %d\\n\", y.a);\n    printf(\"x->a = %d\\n\", x->a);\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A)x 是一個結構指標，指向結構變數 y'],
            ['key' => 'B', 'text' => '(B)a 是結構變數 y 的其中一個成員'],
            ['key' => 'C', 'text' => '(C)y.a 的值是 1'],
            ['key' => 'D', 'text' => '(D)以上皆正確'],
        ],
        'correct_answer' => 'D',
        'explanation_html' => <<<HTML
<h4>詳解 (C/C++ Context)</h4>
<p><strong>1. 關鍵概念：指標、結構、成員存取</strong></p>
<p>假設 <code>y</code> 是一個結構變數，該結構型態有一個成員 <code>a</code>，且 <code>x</code> 是指向該結構型態的指標。</p>
<p><strong>2. 程式碼片段分析：</strong></p>
<ol>
    <li><strong><code>x = &amp;y;</code></strong>：指標 <code>x</code> 指向結構變數 <code>y</code>。</li>
    <li><strong><code>x-&gt;a = 1;</code></strong>：透過指標 <code>x</code>，將 <code>y</code> 的成員 <code>a</code> 的值設定為 1。</li>
</ol>
<p><strong>3. 選項分析：</strong></p>
<ul>
    <li><strong>(A) x 是一個結構指標，指向結構變數 y：</strong>正確。</li>
    <li><strong>(B) a 是結構變數 y 的其中一個成員：</strong>正確 (這是語法成立的前提)。</li>
    <li><strong>(C) y.a 的值是 1：</strong>正確，因為 <code>x-&gt;a = 1;</code> 修改了 <code>y.a</code>。</li>
    <li><strong>(D) 以上皆正確：</strong>正確。</li>
</ul>
<p><strong>4. 結論：</strong></p>
<p>所有描述 (A), (B), 和 (C) 都是正確的。</p>
HTML
    ],
    [
        'id_suffix' => '17',
        'question_text' => '17. C++語言的保留字有其特殊的含意，下列有關於保留字的說明，何者錯誤？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)break：中斷程式的執行，離開目前的程式區塊'],
            ['key' => 'B', 'text' => '(B)this：指向物件本身的指標'],
            ['key' => 'C', 'text' => '(C)const：建立自訂的結構型態'],
            ['key' => 'D', 'text' => '(D)continue：忽略後面的程式碼，立刻執行下一次迴圈'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：C++ 保留字</strong></p>
<ul>
    <li><strong><code>break</code>：</strong>用於跳出迴圈或 switch。</li>
    <li><strong><code>this</code>：</strong>在非靜態成員函式中，指向呼叫該函式的物件。</li>
    <li><strong><code>const</code>：</strong>型別限定字，用於宣告常數或常數行為。建立結構用 <code>struct</code>。</li>
    <li><strong><code>continue</code>：</strong>跳過當前迴圈迭代的剩餘部分，開始下一次迭代。</li>
</ul>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) break：中斷程式的執行，離開目前的程式區塊：</strong>正確。</li>
    <li><strong>(B) this：指向物件本身的指標：</strong>正確。</li>
    <li><strong>(C) const：建立自訂的結構型態：</strong>錯誤。<code>const</code> 用於定義常數；<code>struct</code> 用於建立結構。</li>
    <li><strong>(D) continue：忽略後面的程式碼，立刻執行下一次迴圈：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>敘述「(C) const：建立自訂的結構型態」是錯誤的。</p>
HTML
    ],
    [
        'id_suffix' => '18',
        'question_text' => '18. 有關 C++語言的類別建構子，哪一個描述是錯誤的？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)建構子可以重載'],
            ['key' => 'B', 'text' => '(B)建構子的名稱必須和類別名稱相同'],
            ['key' => 'C', 'text' => '(C)建構子一定要有回傳值'],
            ['key' => 'D', 'text' => '(D)宣告物件時，會自動呼叫建構子，完成物件初始化'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：C++ 類別建構子</strong></p>
<ul>
    <li>名稱與類別名相同。</li>
    <li>沒有回傳型別 (連 <code>void</code> 都不寫)。</li>
    <li>可以重載 (不同參數列表)。</li>
    <li>創建物件時自動呼叫以初始化。</li>
</ul>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) 建構子可以重載：</strong>正確。</li>
    <li><strong>(B) 建構子的名稱必須和類別名稱相同：</strong>正確。</li>
    <li><strong>(C) 建構子一定要有回傳值：</strong>錯誤。建構子沒有回傳型態。</li>
    <li><strong>(D) 宣告物件時，會自動呼叫建構子，完成物件初始化：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>敘述「(C) 建構子一定要有回傳值」是錯誤的。</p>
HTML
    ],
    [
        'id_suffix' => '19',
        'question_text' => '19. 有一函式原型 void key( )，下列何者不是其合法的重載函式？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)void key(int)，'],
            ['key' => 'B', 'text' => '(B)int key(float)，'],
            ['key' => 'C', 'text' => '(C)	void key(int， int)，'],
            ['key' => 'D', 'text' => '(D)int key( )，'],
        ],
        'correct_answer' => 'D',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：函式重載 (Function Overloading)</strong></p>
<p>函式重載允許同名函式，但其參數列表必須不同 (數量、型態或順序)。回傳型態不能作為區分重載的唯一依據。</p>
<p>原始函式：<code>void key()</code> (無參數)</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) <code>void key(int)</code>：</strong>參數列表不同 (一個 int)，合法重載。</li>
    <li><strong>(B) <code>int key(float)</code>：</strong>參數列表不同 (一個 float)，合法重載 (回傳型態不同不影響)。</li>
    <li><strong>(C) <code>void key(int, int)</code>：</strong>參數列表不同 (兩個 int)，合法重載。</li>
    <li><strong>(D) <code>int key()</code>：</strong>參數列表相同 (無參數)。僅回傳型態不同，不合法重載，會導致重定義錯誤。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>選項 (D) <code>int key()</code> 不是 <code>void key()</code> 的合法重載函式。</p>
HTML
    ],
    [
        'id_suffix' => '20',
        'question_text' => '20. 關於下列程式碼片段的功能說明，哪一個是錯誤的？<pre><code class="language-cpp">class box{\\nprivate:\\n    int x, y;\\npublic:\\n    box(){\\n        this->x=10; this->y=10;\\n    }\\n    box(int x, int y){\\n        this->x = x; this->y = y;\\n    }\\n};</code></pre>',
        'code_snippet' => null, // Code is in question_text
        'run_code_id' => 'q20-code',
        'code_snippet_for_runner' => "#include <iostream>\n\nclass box{\nprivate:\n    int x, y;\npublic:\n    box(){\n        this->x=10; \n        this->y=10;\n        // std::cout << \"Default constructor called. x=\" << this->x << \", y=\" << this->y << std::endl;\n    }\n    box(int x, int y){\n        this->x = x; \n        this->y = y;\n        // std::cout << \"Parameterized constructor called. x=\" << this->x << \", y=\" << this->y << std::endl;\n    }\n    void print_values() {\n        std::cout << \"Box values: x=\" << x << \", y=\" << y << std::endl;\n    }\n};\n\nint main() {\n    box b1;\n    b1.print_values();\n    box b2(5, 25);\n    b2.print_values();\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A)宣告一個 box 類別，有 4 個成員'],
            ['key' => 'B', 'text' => '(B)x 和 y 是公有成員，可以直接存取'],
            ['key' => 'C', 'text' => '(C)有 2 個重載的建構子，可以對物件初始化'],
            ['key' => 'D', 'text' => '(D)this 是指向物件本身的指標'],
        ],
        'correct_answer' => 'B',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：C++ 類別定義</strong></p>
<p>類別 <code>box</code> 有：</p>
<ul>
    <li>私有資料成員：<code>int x, y;</code></li>
    <li>公有成員函式：一個預設建構子 <code>box()</code> 和一個參數化建構子 <code>box(int x, int y)</code>。</li>
</ul>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) 宣告一個 box 類別，有 4 個成員：</strong>不精確。有2個資料成員和2個成員函式 (建構子)。</li>
    <li><strong>(B) x 和 y 是公有成員，可以直接存取：</strong>錯誤。<code>x</code> 和 <code>y</code> 在 <code>private</code> 區塊，是私有成員。</li>
    <li><strong>(C) 有 2 個重載的建構子，可以對物件初始化：</strong>正確。</li>
    <li><strong>(D) this 是指向物件本身的指標：</strong>正確 (在成員函式內部)。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>選項 (B) 是明確錯誤的。選項 (A) 也不完全準確，但 (B) 的錯誤更為直接。</p>
HTML
    ],
    [
        'id_suffix' => '21',
        'question_text' => '21. 在 C++中宣告類別時，將資料成員宣告在哪個修飾子區塊內，可以達到物件導向的 「封裝」特性？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)public'],
            ['key' => 'B', 'text' => '(B)hidden'],
            ['key' => 'C', 'text' => '(C)private'],
            ['key' => 'D', 'text' => '(D)close'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：封裝與存取修飾子</strong></p>
<p>封裝是 OOP 的核心，旨在隱藏物件的內部狀態，並透過公有介面進行互動。C++ 使用存取修飾子 (<code>public</code>, <code>private</code>, <code>protected</code>) 控制成員的可見性。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) public：</strong>使成員可從任何地方存取，不利於封裝資料。</li>
    <li><strong>(B) hidden：</strong>非 C++ 標準關鍵字。</li>
    <li><strong>(C) private：</strong>使成員僅能被同一類別的成員函式存取，是實現資料隱藏和封裝的主要方式。</li>
    <li><strong>(D) close：</strong>非 C++ 標準關鍵字。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>將資料成員宣告在 <code>private</code> 區塊內可以達到封裝特性。</p>
HTML
    ],
    [
        'id_suffix' => '22',
        'question_text' => '22. 要將 C++中的成員函式做為對外的操作介面，達到資料隠藏的功能，必須使用哪一個修飾子來宣告成員函式？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)public'],
            ['key' => 'B', 'text' => '(B)private'],
            ['key' => 'C', 'text' => '(C)open'],
            ['key' => 'D', 'text' => '(D)external'],
        ],
        'correct_answer' => 'A',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：資料隱藏與公有介面</strong></p>
<p>資料隱藏是透過將資料成員設為 <code>private</code> 或 <code>protected</code> 來實現的。為了讓外部程式碼能夠與物件互動並間接存取這些被隱藏的資料，類別需要提供一組公有的操作介面，即公有成員函式 (public member functions)。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) public：</strong>正確。公有成員函式構成類別的外部介面。</li>
    <li><strong>(B) private：</strong>私有成員函式只能在類別內部被呼叫。</li>
    <li><strong>(C) open：</strong>非 C++ 標準關鍵字。</li>
    <li><strong>(D) external：</strong><code>extern</code> 關鍵字與連結性有關，與成員存取權限無關。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>成員函式若要作為對外操作介面，必須使用 <code>public</code> 修飾子宣告。</p>
HTML
    ],
    [
        'id_suffix' => '23',
        'question_text' => '23. C++語言支援物件導向的功能，要在程式中宣告一個類別，需使用哪一個關鍵字？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)object'],
            ['key' => 'B', 'text' => '(B)struct'],
            ['key' => 'C', 'text' => '(C)define'],
            ['key' => 'D', 'text' => '(D)class'],
        ],
        'correct_answer' => 'D',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：C++ 類別宣告</strong></p>
<p>在 C++ 中，<code>class</code> 關鍵字用於宣告一個類別，這是物件導向程式設計的基礎。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) object：</strong>物件是類別的實例，不是宣告類別的關鍵字。</li>
    <li><strong>(B) struct：</strong>雖然在 C++ 中 <code>struct</code> 功能上與 <code>class</code> 相似 (主要差在預設存取權限)，但題目問的是宣告「類別」的典型關鍵字。</li>
    <li><strong>(C) define：</strong><code>#define</code> 是前置處理指令。</li>
    <li><strong>(D) class：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>使用 <code>class</code> 關鍵字在 C++ 中宣告類別。</p>
HTML
    ],
    [
        'id_suffix' => '24',
        'question_text' => '24. 有關 C/C++語言的敘述，下列何者正確？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)C 和 C++語言都支援物件導向功能'],
            ['key' => 'B', 'text' => '(B)C  語言沒有字串(string)資料型別'],
            ['key' => 'C', 'text' => '(C)C++語言不支援函式重載'],
            ['key' => 'D', 'text' => '(D)C  是低階語言，C++是高階語言'],
        ],
        'correct_answer' => 'B',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：C 與 C++ 語言特性比較</strong></p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) C 和 C++語言都支援物件導向功能：</strong>錯誤。C 不支援 OOP；C++ 支援。</li>
    <li><strong>(B) C 語言沒有字串(string)資料型別：</strong>正確。C 使用字元陣列處理字串，沒有內建 <code>string</code> 型別。</li>
    <li><strong>(C) C++語言不支援函式重載：</strong>錯誤。C++ 支援函式重載。</li>
    <li><strong>(D) C 是低階語言，C++是高階語言：</strong>不完全準確。兩者都可視為中階語言。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>敘述「(B) C 語言沒有字串(string)資料型別」是正確的。</p>
HTML
    ],
    [
        'id_suffix' => '25',
        'question_text' => '25. C++語言的 this 關鍵字，表示指向物件本身的指標，要經由 this 存取自身的資料成員，需使用哪一個運算子？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)「.」'],
            ['key' => 'B', 'text' => '(B)「*」'],
            ['key' => 'C', 'text' => '(C)「->」'],
            ['key' => 'D', 'text' => '(D)「::」'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：<code>this</code> 指標</strong></p>
<p><code>this</code> 是 C++ 非靜態成員函式中的一個隱含指標，指向呼叫該函式的物件。要透過指標存取成員，使用箭頭運算子 (<code>-&gt;</code>) 或解參考再用點運算子 (<code>(*this).member</code>)。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) 「.」：</strong>用於物件變數直接存取成員。</li>
    <li><strong>(B) 「*」：</strong>用於解參考指標。</li>
    <li><strong>(C) 「->」：</strong>正確。用於透過指標 (如 <code>this</code>) 存取成員。</li>
    <li><strong>(D) 「::」：</strong>範疇解析運算子。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>經由 <code>this</code> 指標存取資料成員，需使用箭頭運算子 <code>-&gt;</code>。</p>
HTML
    ],
    [
        'id_suffix' => '26',
        'question_text' => '26. 小智宣告一個 C++的類別 pcb，下列哪個選項是其建構子的實作？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)pcb::pcb(int){ . . }，'],
            ['key' => 'B', 'text' => '(B)int pcb::layout( ){ . . }，'],
            ['key' => 'C', 'text' => '(C)void pcb::route( ){ . . }，'],
            ['key' => 'D', 'text' => '(D)void pcb::import(int) { . . }，'],
        ],
        'correct_answer' => 'A',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：C++ 類別建構子</strong></p>
<p>建構子名稱與類別名相同，且沒有回傳型別。在類別外定義時使用範疇解析運算子 <code>::</code>。</p>
<p><strong>2. 選項分析：</strong></p>
<p>類別名稱為 <code>pcb</code>。</p>
<ul>
    <li><strong>(A) <code>pcb::pcb(int){ . . }</code>：</strong>名稱與類別名相同 (<code>pcb</code>)，無回傳型別。這是合法的建構子實作。</li>
    <li><strong>(B) <code>int pcb::layout( ){ . . }</code>：</strong>名稱 <code>layout</code> 不同，有回傳型別 <code>int</code>。不是建構子。</li>
    <li><strong>(C) <code>void pcb::route( ){ . . }</code>：</strong>名稱 <code>route</code> 不同，有回傳型態 <code>void</code>。不是建構子。</li>
    <li><strong>(D) <code>void pcb::import(int) { . . }</code>：</strong>名稱 <code>import</code> 不同，有回傳型態 <code>void</code>。不是建構子。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>選項 (A) 是 <code>pcb</code> 類別建構子的正確實作形式。</p>
HTML
    ],
    [
        'id_suffix' => '27',
        'question_text' => '27. 執行下列程式片段後的輸出為何？<pre><code class="language-cpp">class model{\\nprivate:\\n    int val[5];\\npublic:\\n    void setNum(int, int);\\n    int getNum(int);\\n};\\nvoid model::setNum(int i, int num){\\n    val[i] = num;\\n}\\nint model::getNum(int i){\\n    return val[i];\\n}\\nint main(){\\n    model m;\\n    for (int i=0; i<5; i++){\\n        m.setNum(i, i);\\n    }\\n    std::cout << m.getNum(4);\\n}</code></pre>',
        'code_snippet' => null, // Code is in question_text
        'run_code_id' => 'q27-code',
        'code_snippet_for_runner' => "#include <iostream>\n\nclass model{\nprivate:\n    int val[5];\npublic:\n    void setNum(int index, int num);\n    int getNum(int index);\n};\n\nvoid model::setNum(int i, int num){\n    if (i >= 0 && i < 5) {\n        val[i] = num;\n    }\n}\n\nint model::getNum(int i){\n    if (i >= 0 && i < 5) {\n        return val[i];\n    }\n    return -1; \n}\n\nint main(){\n    model m;\n    for (int i=0; i<5; i++){\n        m.setNum(i, i);\n    }\n    std::cout << m.getNum(4) << std::endl;\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A)1'],
            ['key' => 'B', 'text' => '(B)2'],
            ['key' => 'C', 'text' => '(C)3'],
            ['key' => 'D', 'text' => '(D)4'],
        ],
        'correct_answer' => 'D',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：類別、物件、成員函式、陣列</strong></p>
<p><strong>2. 程式碼執行追蹤：</strong></p>
<ol>
    <li><code>model m;</code>：創建物件 <code>m</code>。</li>
    <li><code>for (int i=0; i<5; i++){ m.setNum(i, i); }</code>：
        <ul>
            <li><code>m.setNum(0,0)</code> -> <code>m.val[0] = 0</code></li>
            <li><code>m.setNum(1,1)</code> -> <code>m.val[1] = 1</code></li>
            <li>...</li>
            <li><code>m.setNum(4,4)</code> -> <code>m.val[4] = 4</code></li>
        </ul>
        物件 <code>m</code> 內部的 <code>val</code> 陣列為 <code>{0, 1, 2, 3, 4}</code>。
    </li>
    <li><code>std::cout &lt;&lt; m.getNum(4);</code>：呼叫 <code>m.getNum(4)</code>，回傳 <code>m.val[4]</code>，即 <code>4</code>。</li>
</ol>
<p><strong>3. 結論：</strong></p>
<p>程式執行後的輸出為 4。</p>
HTML
    ],
    [
        'id_suffix' => '28',
        'question_text' => '28. 執行下列程式片段後的輸出為何？<pre><code class="language-cpp">class base{\\nprivate:\\n    int a, b;\\n    void setA(int a){ this->a = a; }\\n    void setB(int b){ this->b = b; }\\npublic:\\n    base(int, int);\\n    void begin(int, int);\\n    int getA();\\n    int getB();\\n};\\nbase::base(int a, int b){\\n    this->a = a;\\n    this->b = b;\\n}\\nvoid base::begin(int a, int b){\\n    setA(b);\\n    setB(a);\\n}\\nint base::getA(){ return this->a; }\\nint base::getB(){ return this->b; }\\n\\nint main(){\\n    base B(1, 2);\\n    B.begin(3, 4);\\n    std::cout << B.getA() << std::endl;\\n}</code></pre>',
        'code_snippet' => null, // Code is in question_text
        'run_code_id' => 'q28-code',
        'code_snippet_for_runner' => "#include <iostream>\n\nclass base{\nprivate:\n    int a, b;\n    void setA(int val_a){ this->a = val_a; }\n    void setB(int val_b){ this->b = val_b; }\npublic:\n    base(int init_a, int init_b);\n    void begin(int param_a, int param_b);\n    int getA();\n    int getB();\n};\nbase::base(int init_a, int init_b){\n    this->a = init_a;\n    this->b = init_b;\n}\nvoid base::begin(int param_a, int param_b){\n    setA(param_b);\n    setB(param_a);\n}\nint base::getA(){ return this->a; }\nint base::getB(){ return this->b; }\n\nint main(){\n    base B(1, 2);\n    B.begin(3, 4);\n    std::cout << B.getA() << std::endl;\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A)1'],
            ['key' => 'B', 'text' => '(B)2'],
            ['key' => 'C', 'text' => '(C)3'],
            ['key' => 'D', 'text' => '(D)4'],
        ],
        'correct_answer' => 'D',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：類別、建構子、成員函式、<code>this</code> 指標</strong></p>
<p><strong>2. 程式碼執行追蹤：</strong></p>
<ol>
    <li><strong><code>base B(1, 2);</code></strong>：呼叫建構子。<code>B.a</code> 設為 1，<code>B.b</code> 設為 2。</li>
    <li><strong><code>B.begin(3, 4);</code></strong>：呼叫 <code>begin</code> 函式，參數 <code>a</code> 為 3，參數 <code>b</code> 為 4。
        <ul>
            <li>內部呼叫 <code>setA(b)</code>，即 <code>setA(4)</code>。這使得 <code>B.a</code> (<code>this-&gt;a</code>) 變為 4。</li>
            <li>內部呼叫 <code>setB(a)</code>，即 <code>setB(3)</code>。這使得 <code>B.b</code> (<code>this-&gt;b</code>) 變為 3。</li>
        </ul>
        此時，<code>B.a = 4</code>, <code>B.b = 3</code>。
    </li>
    <li><strong><code>std::cout &lt;&lt; B.getA() &lt;&lt; std::endl;</code></strong>：呼叫 <code>B.getA()</code>，回傳 <code>B.a</code>，即 <code>4</code>。</li>
</ol>
<p><strong>3. 結論：</strong></p>
<p>程式執行後的輸出為 4。</p>
HTML
    ],
];

$html_title = "C++ 物件導向進階測驗 (EE7-6)";

?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($html_title); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&family=Source+Code+Pro:wght@400;500&display=swap" rel="stylesheet">
    <script>
    MathJax = {
      tex: {
        inlineMath: [['$', '$'], ['\\(', '\\)']],
        displayMath: [['$$', '$$'], ['\\[', '\\]']]
      }
    };
    </script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
</head>
<body>
    <nav class="simple-nav">
        <a href="index.php">返回主頁</a>
        | <a href="ee7-1.php">EE7-1 C++ OOP測驗 I</a>
        | <a href="ee7-5.php">EE7-5 C/C++綜合測驗</a>
        | EE7-6 C++ OOP測驗 II (本頁)
    </nav>
    <div class="container">
        <main class="tutorial-content">
            <h1>C++ 物件導向進階測驗 (EE7-6)</h1>
            <p>本頁面包含一系列 C++ 物件導向程式設計的進階練習題，涵蓋類別、物件、繼承、建構子、解構子、this 指標、封裝等重要概念。請仔細研讀每個題目和程式碼片段，並利用右側的沙箱進行實作與驗證。</p>

            <div class="quiz-section" id="quiz-section-dynamic">
                <h2>C++ 物件導向進階練習題組 (EE7-6)</h2>
                <p>請挑戰下面的題目，檢驗您的 C++ OOP 知識！ (共 <?php echo count($current_exercises); ?> 題)</p>

                <?php foreach ($current_exercises as $index => $exercise): ?>
                    <div id="q<?php echo htmlspecialchars($exercise['id_suffix']); ?>" class="quiz-card">
                        <h3><?php
                            $q_text = $exercise['question_text'];
                            if (preg_match('/^(.*?)?(<pre><code[^>]*>)(.*?)(<\\/code><\\/pre>)(.*?)?$/s', $q_text, $parts)) {
                                if (!empty(trim($parts[1]))) { echo nl2br(htmlspecialchars(trim($parts[1]))); }
                                $code_content = str_replace("\\\\n", "\\n", $parts[3]);
                                echo $parts[2] . htmlspecialchars($code_content) . $parts[4];
                                if (!empty(trim($parts[5]))) { echo nl2br(htmlspecialchars(trim($parts[5]))); }
                            } else {
                                echo nl2br(htmlspecialchars($q_text));
                            }
                        ?></h3>

                        <?php
                        if (!empty($exercise['code_snippet']) && (strpos($exercise['question_text'], '<pre><code') === false)) :
                            $formatted_separate_snippet = str_replace("\\\\n", "\\n", $exercise['code_snippet']);
                        ?>
                            <pre><code class="language-cpp"><?php echo htmlspecialchars($formatted_separate_snippet); ?></code></pre>
                        <?php endif; ?>

                        <?php if (!empty($exercise['run_code_id']) && !empty($exercise['code_snippet_for_runner'])): ?>
                            <button class="run-example-btn" data-code-id="<?php echo htmlspecialchars($exercise['run_code_id']); ?>">運行示例</button>
                        <?php endif; ?>

                        <div class="quiz-options" data-correct="<?php echo htmlspecialchars($exercise['correct_answer']); ?>">
                            <?php foreach ($exercise['options'] as $option): ?>
                                <div class="option" data-option="<?php echo htmlspecialchars($option['key']); ?>">
                                    <?php echo str_replace('&amp;','&', htmlspecialchars($option['text'])); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="explanation">
                            <?php echo $exercise['explanation_html']; ?>
                        </div>
                        <div class="next-btn-container">
                            <?php if ($index < count($current_exercises) - 1): ?>
                                <button class="next-btn" data-target="#q<?php echo htmlspecialchars($current_exercises[$index + 1]['id_suffix']); ?>">下一題</button>
                            <?php else: ?>
                                <button class="next-btn" data-target="#q<?php echo htmlspecialchars($current_exercises[0]['id_suffix']); ?>">回到第一題</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>

        <div class="resizer" id="dragMe"></div>

        <aside class="interactive-panel">
            <div class="interactive-panel-inner">
                <div class="sandbox-container">
                    <h3>C++ 程式碼沙箱 (WASM)</h3>
                    <textarea id="code-editor" spellcheck="false">/* 點擊題目下方的「運行示例」按鈕以載入程式碼，或在此處編寫您自己的 C++ 程式碼。 */</textarea>
                    <div class="sandbox-controls">
                        <button id="run-code-btn">編譯與執行</button>
                    </div>
                    <pre id="output-area" aria-live="polite">輸出結果將顯示於此...</pre>
                </div>
            </div>
        </aside>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <script src="script.js"></script>
    <script>
        window.pageCodeSamples = {
            <?php
            $runnable_samples_ee7_6 = [];
            if (isset($current_exercises) && is_array($current_exercises)) {
                foreach ($current_exercises as $exercise) {
                    if (!empty($exercise['run_code_id']) && !empty($exercise['code_snippet_for_runner'])) {
                        // Ensure literal \\n in PHP string becomes \n in JS string for the editor
                        $js_code = str_replace("\\\\n", "\\n", $exercise['code_snippet_for_runner']);
                        $js_code = str_replace("'", "\\'", $js_code); // Escape single quotes for JS string
                        $js_code = str_replace("\"", "\\\"", $js_code); // Escape double quotes for JS string

                        $runnable_samples_ee7_6[] = "'" . addslashes($exercise['run_code_id']) . "': \"" . $js_code . "\"";
                    }
                }
            }
            echo implode(",\n            ", $runnable_samples_ee7_6);
            if (empty($runnable_samples_ee7_6)) {
                 echo "'q_default_sample_ee7_6': \"#include <iostream>\\n\\nint main() {\\n    std::cout << \\\"Hello, C++ world! EE7-6\\\" << std::endl;\\n    return 0;\\n}\"";
            }
            ?>
        };

        document.addEventListener('DOMContentLoaded', function() {
            const codeEditor = document.getElementById('code-editor');
            if (window.pageCodeSamples && Object.keys(window.pageCodeSamples).length > 0) {
                const firstSampleKey = Object.keys(window.pageCodeSamples)[0];
                if (window.pageCodeSamples[firstSampleKey]) {
                    codeEditor.value = window.pageCodeSamples[firstSampleKey];
                }
            } else {
                 codeEditor.value = "// No runnable C++ examples specifically for this page. Write your code here.";
            }
        });
    </script>
</body>
</html>
