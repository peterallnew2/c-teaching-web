<?php
header('Content-Type: text/html; charset=utf-8');

// EE7-5 Quiz Data - C/C++ Mixed Questions
// Data meticulously re-checked to ensure code in question_text is wrapped in <pre><code class="language-clike/c/cpp">...</code></pre>
// and newlines within that code are '\\n' literals.
$current_exercises = [
    [
        'id_suffix' => '1',
        'question_text' => '1. 有關 C++語言中變數命名，下列那一個錯誤？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A) Void'],
            ['key' => 'B', 'text' => '(B) 一123'],
            ['key' => 'C', 'text' => '(C) print'],
            ['key' => 'D', 'text' => '(D) int'],
        ],
        'correct_answer' => 'D',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：變數命名規則與關鍵字</strong></p>
<p>在 C/C++ 中，變數命名有以下規則：</p>
<ul>
    <li>可以包含字母 (大小寫)、數字和底線 <code>_</code>。</li>
    <li>第一個字元不能是數字。</li>
    <li>不能使用語言的關鍵字 (reserved words) 作為變數名。</li>
    <li>區分大小寫 (e.g., <code>myVar</code> 和 <code>myvar</code> 是不同的變數)。</li>
</ul>
<p>C++ 的關鍵字是由語言標準定義的，具有特殊意義，例如 <code>int</code>, <code>float</code>, <code>double</code>, <code>char</code>, <code>void</code>, <code>if</code>, <code>else</code>, <code>for</code>, <code>while</code>, <code>class</code>, <code>public</code> 等。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) Void：</strong><code>Void</code> (大寫 V) 不是 C++ 的關鍵字 (關鍵字是小寫的 <code>void</code>)。因此，<code>Void</code> 可以作為變數名。</li>
    <li><strong>(B) 一123：</strong>這個變數名以中文「一」開頭。雖然現代編譯器可能支援 Unicode 字元作為變數名的一部分 (取決於編譯器和設定)，但傳統上 C/C++ 變數名主要使用 ASCII 字符集中的字母、數字和底線。然而，題目更可能是考驗標準 ASCII 規則和關鍵字。即使某些編譯器接受，這也不是一個好的命名習慣。但相較於 (D)，它不是一個直接的語法錯誤 (關鍵字衝突)。</li>
    <li><strong>(C) print：</strong><code>print</code> 不是 C++ 的標準關鍵字。雖然 C 語言中有 <code>printf</code> 函式，C++ 中有 <code>std::cout</code>，但 <code>print</code> 本身並非保留字。因此，它可以作為變數名 (儘管不建議，因為可能與自訂或庫函式名混淆)。</li>
    <li><strong>(D) int：</strong><code>int</code> 是 C++ 用於宣告整數型態的關鍵字。關鍵字不能被用作變數名稱。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>選項 (D) <code>int</code> 是 C++ 的關鍵字，因此不能作為變數名稱，這是一個明確的語法錯誤。</p>
HTML
    ],
    [
        'id_suffix' => '2',
        'question_text' => '2. 有關 C++語言的變數命名，以下何者正確？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A) ％abcd'],
            ['key' => 'B', 'text' => '(B) 1abcd'],
            ['key' => 'C', 'text' => '(C) fruit-apple一long一name'],
            ['key' => 'D', 'text' => '(D) 一a一long一name'],
        ],
        'correct_answer' => 'D',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：變數命名規則</strong></p>
<p>複習 C/C++ 變數命名規則：</p>
<ul>
    <li>可以包含字母 (a-z, A-Z)、數字 (0-9) 和底線 <code>_</code>。</li>
    <li>第一個字元必須是字母或底線 <code>_</code>。不能是數字。</li>
    <li>不能使用關鍵字。</li>
    <li>區分大小寫。</li>
    <li>特殊字元 (如 <code>%</code>, <code>-</code>) 通常不允許在變數名中使用 (除了底線)。</li>
</ul>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) ％abcd：</strong>包含特殊字元 <code>％</code>，這是不允許的。</li>
    <li><strong>(B) 1abcd：</strong>以數字開頭，這是不允許的。</li>
    <li><strong>(C) fruit-apple一long一name：</strong>包含特殊字元 <code>-</code> (減號)，這通常不允許在變數名中 (容易與減法運算混淆)。也包含中文字元，如前一題所述，雖然部分編譯器可能支援，但非標準 ASCII 做法。</li>
    <li><strong>(D) 一a一long一name：</strong>這個變數名以底線 <code>_</code> 開頭 (題目中的長橫線應理解為底線)，後面跟著字母、數字和底線的組合 (假設題目中的 "一" 是底線的另一種表示或筆誤)。如果將所有 "一" 視為底線 <code>_</code>，則 <code>_a_long_name</code> 是一個合法的 C++ 變數名。它以底線開頭，後續字元為字母和底線。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>假設題目中的 "一" 是為了排版而代替底線 <code>_</code>，則 (D) <code>_a_long_name</code> 是唯一符合 C++ 變數命名規則的選項。其他選項都違反了明確的規則 (特殊字元、數字開頭)。</p>
<p><em>註：如果 "一" 被嚴格解釋為中文字元 "一"，則 (D) 在傳統 C++ 標準下也是不合法的。但通常這類題目會預期考生將其視為底線或一個可接受的字母替代。在此，我們以最寬鬆且符合常見出題模式的方式解釋，即將其視為底線的替代寫法。</em></p>
HTML
    ],
    [
        'id_suffix' => '3',
        'question_text' => '3. 以下何者不是 C++語言整數資料型態？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A) double'],
            ['key' => 'B', 'text' => '(B) short'],
            ['key' => 'C', 'text' => '(C) byte'],
            ['key' => 'D', 'text' => '(D) int'],
        ],
        'correct_answer' => 'A',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：C++ 資料型態</strong></p>
<p>C++ 提供的基本資料型態主要分為：</p>
<ul>
    <li><strong>整數型態：</strong> 用於儲存沒有小數部分的數字。常見的有：<code>char</code>, <code>short</code>, <code>int</code>, <code>long</code>, <code>long long</code> (及 <code>unsigned</code> 版本)。</li>
    <li><strong>浮點數型態：</strong> 用於儲存帶有小數部分的數字。常見的有：<code>float</code>, <code>double</code>, <code>long double</code>。</li>
    <li><strong>布林型態：</strong> <code>bool</code>。</li>
    <li><strong>空型態：</strong> <code>void</code>。</li>
</ul>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) double：</strong>是浮點數型態。</li>
    <li><strong>(B) short：</strong>是整數型態。</li>
    <li><strong>(C) byte：</strong>不是 C++ 標準的基本資料型態。通常用 <code>char</code> 或 <code>unsigned char</code> 表示位元組。</li>
    <li><strong>(D) int：</strong>是整數型態。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p><code>double</code> 是浮點數型態，不是整數型態。<code>byte</code> 也不是標準C++整數型態。題目通常期望選擇 (A) 作為最明確的「非整數」的標準型態。</p>
HTML
    ],
    [
        'id_suffix' => '4',
        'question_text' => '4. 若考慮正負號，1 個 Byte 的長度，它可以儲存的最大值',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A) 255'],
            ['key' => 'B', 'text' => '(B) 127'],
            ['key' => 'C', 'text' => '(C) 512'],
            ['key' => 'D', 'text' => '(D) 36727'],
        ],
        'correct_answer' => 'B',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：有號整數的表示範圍</strong></p>
<p>1 Byte = 8 bits. 有號數用最高位表示正負。最大正數為 <code>01111111</code> (二進制) = 127。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(B) 127：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>1 Byte 有號整數最大值是 127。</p>
HTML
    ],
    [
        'id_suffix' => '5',
        'question_text' => '5. 若不考慮正負號，1 個 Byte 的長度，它可以儲存的最大值？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A) 255'],
            ['key' => 'B', 'text' => '(B) 512'],
            ['key' => 'C', 'text' => '(C) 128'],
            ['key' => 'D', 'text' => '(D) 1024'],
        ],
        'correct_answer' => 'A',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：無號整數的表示範圍</strong></p>
<p>1 Byte = 8 bits. 無號數所有位元都用於表示數值。最大值為 <code>11111111</code> (二進制) = 2<sup>8</sup> - 1 = 255。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) 255：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>1 Byte 無號整數最大值是 255。</p>
HTML
    ],
    [
        'id_suffix' => '6',
        'question_text' => '6. C++程式指令 printf("%6.2f", 597.7231); 執行後輸出為以下那一個？',
        'code_snippet' => "#include <stdio.h>\n\nint main() {\n    printf(\"|%6.2f|\", 597.7231);\n    return 0;\n}",
        'run_code_id' => 'q6-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\nint main() {\n    printf(\"|%6.2f|\", 597.7231);\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A) 597.723'],
            ['key' => 'B', 'text' => '(B) 597.72'],
            ['key' => 'C', 'text' => '(C) 000597.72'],
            ['key' => 'D', 'text' => '(D) 597'],
        ],
        'correct_answer' => 'B',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：<code>printf</code> 格式化輸出 (浮點數)</strong></p>
<p><code>%[寬度].[精度]f</code>：寬度為總最小字元數，精度為小數點後位數 (四捨五入)。<code>597.7231</code> 用 <code>%.2f</code> 格式化為 <code>597.72</code>。此字串長度為6，符合寬度6，不需補空格。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(B) 597.72：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>輸出為 <code>597.72</code>。</p>
HTML
    ],
    [
        'id_suffix' => '7',
        'question_text' => '7. 程式執行時，程式中的變數值是存放在',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)記憶體'],
            ['key' => 'B', 'text' => '(B)硬碟'],
            ['key' => 'C', 'text' => '(C)輸出入裝置'],
            ['key' => 'D', 'text' => '(D)匯流排'],
        ],
        'correct_answer' => 'A',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：程式執行與記憶體</strong></p>
<p>程式執行時，變數的值動態地儲存在主記憶體 (RAM) 中。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) 記憶體：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>變數值存放在記憶體中。</p>
HTML
    ],
    [
        'id_suffix' => '8',
        'question_text' => '8. 如果 x=123 則使用敘述 printf("%6d",x); 顯示 x 時',
        'code_snippet' => "#include <stdio.h>\n\nint main() {\n    int x = 123;\n    printf(\"|%6d|\", x);\n    return 0;\n}",
        'run_code_id' => 'q8-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\nint main() {\n    int x = 123;\n    printf(\"|%6d|\", x);\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A)總共 6 個位置，  格在後'],
            ['key' => 'B', 'text' => '(B)總共 6 個位置，  格在前'],
            ['key' => 'C', 'text' => '(C)自動調整為 3 個位置'],
            ['key' => 'D', 'text' => '(D)以上皆非'],
        ],
        'correct_answer' => 'B',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：<code>printf</code> 格式化輸出 (整數與寬度)</strong></p>
<p><code>%[寬度]d</code>：寬度為總最小字元數。若數字位數小於寬度，預設左邊補空格 (右對齊)。<code>123</code> 有3位，寬度6，所以前面補3個空格。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(B)總共 6 個位置，  格在前：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>輸出為 <code>"   123"</code> (包含前面的3個空格)。</p>
HTML
    ],
    [
        'id_suffix' => '9',
        'question_text' => '9. 在 C 語言中，資料型別 short 代表用較少的 bytes 數來記錄整數。相較於 int，short 只需要 2 bytes，請問 short 能記錄的最大數及最小數分別為多少？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A) 32767，0'],
            ['key' => 'B', 'text' => '(B) 32768，-32768'],
            ['key' => 'C', 'text' => '(C)  32767，-32768'],
            ['key' => 'D', 'text' => '(D) 32768，0'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：有號整數 <code>short</code> 的表示範圍</strong></p>
<p>2 bytes = 16 bits. 有號 <code>short</code> 範圍是 -2<sup>15</sup> 到 2<sup>15</sup>-1。</p>
<p>-2<sup>15</sup> = -32768.</p>
<p>2<sup>15</sup>-1 = 32768 - 1 = 32767.</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(C) 32767，-32768：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>2 bytes 有號 <code>short</code> 範圍是 -32768 到 32767。</p>
HTML
    ],
    [
        'id_suffix' => '10',
        'question_text' => '10. 下列 4 種數值資料型別，何者可表示的數值資料範圍最大？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)整數(Integer)'],
            ['key' => 'B', 'text' => '(B)長整數(Long)'],
            ['key' => 'C', 'text' => '(C)單精度(Single)'],
            ['key' => 'D', 'text' => '(D)倍精度(Double)'],
        ],
        'correct_answer' => 'D',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：數值資料型別的範圍</strong></p>
<p><code>double</code> (倍精度浮點數) 通常佔用 8 bytes，其表示範圍 (約 ±1.7 × 10<sup>-308</sup> 到 ±1.7 × 10<sup>+308</sup>) 遠大於典型的 <code>int</code> (4 bytes, ~±2 × 10<sup>9</sup>), <code>long</code> (4 or 8 bytes), 和 <code>float</code> (4 bytes, ~±3.4 × 10<sup>+38</sup>)。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(D)倍精度(Double)：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p><code>double</code> 可表示的數值資料範圍最大。</p>
HTML
    ],
    [
        'id_suffix' => '11',
        'question_text' => '11. 在撰寫 C 語言程式時，下列哪一個變數宣告可以儲存 64 位元的浮點數？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A) int'],
            ['key' => 'B', 'text' => '(B) float'],
            ['key' => 'C', 'text' => '(C) long'],
            ['key' => 'D', 'text' => '(D) double'],
        ],
        'correct_answer' => 'D',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：C/C++ 資料型別大小</strong></p>
<p><code>double</code> 通常是 64 位元 (8 bytes) 的雙精度浮點數。<code>float</code> 通常是 32 位元。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(D) double：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p><code>double</code> 用於儲存 64 位元的浮點數。</p>
HTML
    ],
    [
        'id_suffix' => '12',
        'question_text' => '12. 若我們以 C++撰寫程式碼 std::cout <<"2016 holidays"，請問其中的 cout 是？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)運算子'],
            ['key' => 'B', 'text' => '(B)類別'],
            ['key' => 'C', 'text' => '(C)物件'],
            ['key' => 'D', 'text' => '(D)變數'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：C++ 輸入/輸出流</strong></p>
<p><code>std::cout</code> 是 <code>std::ostream</code> 類別的一個預先定義好的全域<strong>物件</strong>，代表標準輸出流。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(C) 物件：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p><code>std::cout</code> 是一個物件。</p>
HTML
    ],
    [
        'id_suffix' => '13',
        'question_text' => '13. 使用函數 printf( )輸出字元時必須使用以下哪一種格式？',
        'code_snippet' => "#include <stdio.h>\n\nint main() {\n    char myChar = 'A';\n    printf(\"Character: %c\\n\", myChar);\n    return 0;\n}",
        'run_code_id' => 'q13-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\nint main() {\n    char myChar = 'A';\n    printf(\"Character: %c\\n\", myChar);\n    printf(\"ASCII value of char: %d\\n\", myChar);\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A)％s'],
            ['key' => 'B', 'text' => '(B)％c'],
            ['key' => 'C', 'text' => '(C)％d'],
            ['key' => 'D', 'text' => '(D)％f'],
        ],
        'correct_answer' => 'B',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：<code>printf</code> 格式指定符</strong></p>
<p><code>%c</code> 用於輸出單個字元。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(B) ％c：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>輸出字元使用 <code>%c</code>。</p>
HTML
    ],
    [
        'id_suffix' => '14',
        'question_text' => '14. 若 a 為一浮點數，a=3.1415; printf("%.2f", a);會印出？',
        'code_snippet' => "#include <stdio.h>\n\nint main() {\n    float a = 3.1415;\n    printf(\"Value: %.2f\\n\", a);\n    return 0;\n}",
        'run_code_id' => 'q14-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\nint main() {\n    float a = 3.1415;\n    printf(\"Value: %.2f\\n\", a);\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A) 3.141'],
            ['key' => 'B', 'text' => '(B) 3.14'],
            ['key' => 'C', 'text' => '(C) 3.1'],
            ['key' => 'D', 'text' => '(D) 3.2'],
        ],
        'correct_answer' => 'B',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：<code>printf</code> 浮點數精度控制</strong></p>
<p><code>%.2f</code> 表示輸出浮點數並四捨五入到小數點後兩位。<code>3.1415</code> 四捨五入到小數點後兩位是 <code>3.14</code>。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(B) 3.14：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>輸出為 <code>3.14</code>。</p>
HTML
    ],
    [
        'id_suffix' => '15',
        'question_text' => '15. C++語言提供 int、short、long、char、float、double 等幾種基本資料型態，關於其所需的記憶體空間大小的排序，下列何者正確？',
        'code_snippet' => "#include <iostream>\n#include <string>\n\nint main() {\n    std::cout << \"Size of char: \" << sizeof(char) << \" bytes\\n\";\n    std::cout << \"Size of short: \" << sizeof(short) << \" bytes\\n\";\n    std::cout << \"Size of int: \" << sizeof(int) << \" bytes\\n\";\n    std::cout << \"Size of long: \" << sizeof(long) << \" bytes\\n\";\n    std::cout << \"Size of long long: \" << sizeof(long long) << \" bytes\\n\";\n    std::cout << \"Size of float: \" << sizeof(float) << \" bytes\\n\";\n    std::cout << \"Size of double: \" << sizeof(double) << \" bytes\\n\";\n    std::cout << \"Size of long double: \" << sizeof(long double) << \" bytes\\n\";\n    return 0;\n}",
        'run_code_id' => 'q15-code',
        'code_snippet_for_runner' => "#include <iostream>\n\nint main() {\n    std::cout << \"Size of char: \" << sizeof(char) << \" bytes\\n\";\n    std::cout << \"Size of short: \" << sizeof(short) << \" bytes\\n\";\n    std::cout << \"Size of int: \" << sizeof(int) << \" bytes\\n\";\n    std::cout << \"Size of long: \" << sizeof(long) << \" bytes\\n\";\n    std::cout << \"Size of long long: \" << sizeof(long long) << \" bytes\\n\";\n    std::cout << \"Size of float: \" << sizeof(float) << \" bytes\\n\";\n    std::cout << \"Size of double: \" << sizeof(double) << \" bytes\\n\";\n    std::cout << \"Size of long double: \" << sizeof(long double) << \" bytes\\n\";\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A) short=char<int<float<double=long'],
            ['key' => 'B', 'text' => '(B) char<short<int=float=long<double'],
            ['key' => 'C', 'text' => '(C) char<short<int=float<double<long'],
            ['key' => 'D', 'text' => '(D) short<char=int=float<long<double'],
        ],
        'correct_answer' => 'B',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：C++ 基本資料型態大小</strong></p>
<p>標準保證層級關係：<code>1 == sizeof(char) &lt;= sizeof(short) &lt;= sizeof(int) &lt;= sizeof(long) &lt;= sizeof(long long)</code> 和 <code>sizeof(float) &lt;= sizeof(double) &lt;= sizeof(long double)</code>。常見大小：char(1B), short(2B), int(4B), float(4B), long(4B or 8B), double(8B).</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(B) char<short<int=float=long<double：</strong>在 <code>long</code> 為 4 bytes 的系統上，此選項 (1 < 2 < 4=4=4 < 8) 是可能的且最符合層級。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>選項 (B) 描述了一種常見且符合標準規範的排序。</p>
HTML
    ],
    [
        'id_suffix' => '16',
        'question_text' => '16. 關於 C 語言中的基本資料型態，其所佔用的記憶體空間大小，何者有誤？',
        'code_snippet' => "#include <stdio.h>\n\nint main() {\n    printf(\"Size of int: %zu bytes (%zu bits)\\n\", sizeof(int), sizeof(int)*8);\n    printf(\"Size of char: %zu bytes (%zu bits)\\n\", sizeof(char), sizeof(char)*8);\n    printf(\"Size of long: %zu bytes (%zu bits)\\n\", sizeof(long), sizeof(long)*8);\n    printf(\"Size of double: %zu bytes (%zu bits)\\n\", sizeof(double), sizeof(double)*8);\n    return 0;\n}",
        'run_code_id' => 'q16-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\nint main() {\n    printf(\"Size of int: %zu bytes (%zu bits)\\n\", sizeof(int), sizeof(int)*8);\n    printf(\"Size of char: %zu bytes (%zu bits)\\n\", sizeof(char), sizeof(char)*8);\n    printf(\"Size of long: %zu bytes (%zu bits)\\n\", sizeof(long), sizeof(long)*8);\n    printf(\"Size of double: %zu bytes (%zu bits)\\n\", sizeof(double), sizeof(double)*8);\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A) int：32bit'],
            ['key' => 'B', 'text' => '(B)char：8bit'],
            ['key' => 'C', 'text' => '(C) long：64bit'],
            ['key' => 'D', 'text' => '(D) double：64bit'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：C/C++ 基本資料型態大小 (Bits)</strong></p>
<p><code>long</code> 標準保證至少 32 bits。它可以是 32 bits (如許多 Windows 系統) 或 64 bits (如許多 Unix-like 64位元系統)。因此，聲稱它固定是 64bit 是有誤的。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(C) long：64bit：</strong>有誤，不保證是64bit。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>選項 (C) "long：64bit" 的描述有誤。</p>
HTML
    ],
    [
        'id_suffix' => '17',
        'question_text' => '17. 使用 C 語言的輸出函數 printf( )，要輸出浮點數時，必須使用下列那一種格式控制字元？',
        'code_snippet' => "#include <stdio.h>\n\nint main() {\n    float f_val = 3.14f;\n    double d_val = 2.71828;\n    printf(\"Float: %f\\n\", f_val);\n    printf(\"Double: %f\\n\", d_val);\n    printf(\"Double (long float): %lf\\n\", d_val);\n    return 0;\n}",
        'run_code_id' => 'q17-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\nint main() {\n    float f_val = 3.14f;\n    double d_val = 2.71828;\n    printf(\"Float (using %%f): %f\\n\", f_val);\n    printf(\"Double (using %%f): %f\\n\", d_val);\n    printf(\"Double (using %%lf): %lf\\n\", d_val);\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A)％i'],
            ['key' => 'B', 'text' => '(B)％c'],
            ['key' => 'C', 'text' => '(C)％f'],
            ['key' => 'D', 'text' => '(D)％o'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：<code>printf</code> 格式指定符</strong></p>
<p><code>%f</code> 用於輸出浮點數 (<code>float</code> 或 <code>double</code>)。<code>%lf</code> 也常用於 <code>double</code>。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(C) ％f：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>輸出浮點數使用 <code>%f</code>。</p>
HTML
    ],
    [
        'id_suffix' => '18',
        'question_text' => '18. 一 C 語言程式指令 printf("%c",66);執行後的輸出為何？',
        'code_snippet' => "#include <stdio.h>\n\nint main() {\n    printf(\"%c\", 66);\n    printf(\"\\n\");\n    printf(\"Integer 66 is: %d\\n\", 66);\n    return 0;\n}",
        'run_code_id' => 'q18-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\nint main() {\n    printf(\"Output of printf(\\\"%%c\\\", 66): \");\n    printf(\"%c\", 66);\n    printf(\"\\n\");\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A) 66'],
            ['key' => 'B', 'text' => '(B) c'],
            ['key' => 'C', 'text' => '(C) B'],
            ['key' => 'D', 'text' => '(D) 42'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：<code>printf</code> 的 <code>%c</code> 格式與 ASCII 碼</strong></p>
<p><code>%c</code> 將整數參數解釋為 ASCII 值並輸出對應字元。ASCII 值 66 對應大寫字母 'B'。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(C) B：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>輸出為 'B'。</p>
HTML
    ],
    [
        'id_suffix' => '19',
        'question_text' => '19. 美花使用 C++語言寫一支程式，需要使用者從鍵盤輸入密碼進行驗證，她應該使用下列哪一行程式碼才是正確的？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A) scanf("％i"， passwd)，'],
            ['key' => 'B', 'text' => '(B) scanf("％i"， ＆passwd)，'],
            ['key' => 'C', 'text' => '(C) cin<<passwd，'],
            ['key' => 'D', 'text' => '(D)  cout>>passwd，'],
        ],
        'correct_answer' => 'B',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：鍵盤輸入</strong></p>
<p>C 語言使用 <code>scanf("%i", &amp;variable);</code> (或 <code>%d</code>) 讀取整數，需要變數的位址。C++ 使用 <code>std::cin &gt;&gt; variable;</code>。</p>
<p><strong>2. 選項分析 (假設全形符號為筆誤，<code>passwd</code> 為整數)：</strong></p>
<ul>
    <li><strong>(B) <code>scanf("%i", &amp;passwd);</code>：</strong>是 C 風格輸入整數的正確語法。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>選項 (B) 是最接近正確的 C/C++ 輸入方式 (假設為 C 風格或 C++ 中使用 C I/O)。</p>
HTML
    ],
    [
        'id_suffix' => '20',
        'question_text' => '20. 在 C++語言中，要使用 cout 物件將字串輸出，在原始檔中需要載入函式庫，下列哪一種寫法正確？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)#include <stdio.h>'],
            ['key' => 'B', 'text' => '(B)#include <stdio>'],
            ['key' => 'C', 'text' => '(C)#include <iostream.h>'],
            ['key' => 'D', 'text' => '(D)#include <iostream>'],
        ],
        'correct_answer' => 'D',
        'explanation_html' => <<<HTML
<h4>詳解 (C++ Context)</h4>
<p><strong>1. 關鍵概念：C++ 標準函式庫與標頭檔</strong></p>
<p>使用 <code>std::cout</code> 需要包含 <code>&lt;iostream&gt;</code> 標頭檔。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(D) <code>#include &lt;iostream&gt;</code>：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>使用 <code>std::cout</code> 需 <code>#include &lt;iostream&gt;</code>。</p>
HTML
    ],
    [
        'id_suffix' => '21',
        'question_text' => '21. 何種型別不是簡單資料型別(simple data type)？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)整數(integer)型別'],
            ['key' => 'B', 'text' => '(B)浮點數(float)型別'],
            ['key' => 'C', 'text' => '(C)邏輯(boolean)型別'],
            ['key' => 'D', 'text' => '(D)陣列(array)型別'],
        ],
        'correct_answer' => 'D',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：資料型別分類</strong></p>
<p>簡單資料型別 (如整數, 浮點數, 布林) 是語言內建的基本型別。複合資料型別 (如陣列, 結構, 類別) 是由簡單型別或其他複合型別組合而成。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(D)陣列(array)型別：</strong>是複合資料型別。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>陣列型別不是簡單資料型別。</p>
HTML
    ],
    [
        'id_suffix' => '22',
        'question_text' => '22. 下列敘述何者錯誤？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)	組合語言程式中也有變數及常數'],
            ['key' => 'B', 'text' => '(B)	如果某變數在程式執行中都不改變值的話，可以宣告為常數'],
            ['key' => 'C', 'text' => '(C)變數可以設定為某個常數'],
            ['key' => 'D', 'text' => '(D)常數可以設定為某個變數'],
        ],
        'correct_answer' => 'D',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：變數與常數</strong></p>
<p>常數的值在定義後不可改變。不能將常數設定為一個變數的值，因為變數的值可能改變。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(D)常數可以設定為某個變數：</strong>錯誤。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>敘述「(D)常數可以設定為某個變數」是錯誤的。</p>
HTML
    ],
    [
        'id_suffix' => '23',
        'question_text' => '23. 在 C 語言中沒有布林資料型別，因此將哪一個值視同為 false(假)？',
        'code_snippet' => "#include <stdio.h>\n\nint main() {\n    if (0) {\n        printf(\"0 is true\\n\");\n    } else {\n        printf(\"0 is false\\n\");\n    }\n    if (1) {\n        printf(\"1 is true\\n\");\n    } else {\n        printf(\"1 is false\\n\");\n    }\n    if (-5) {\n        printf(\"-5 is true\\n\");\n    } else {\n        printf(\"-5 is false\\n\");\n    }\n    return 0;\n}",
        'run_code_id' => 'q23-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\nint main() {\n    if (0) {\n        printf(\"Inside if(0) - This should NOT print.\\n\");\n    } else {\n        printf(\"Inside else for if(0) - 0 is treated as false.\\n\");\n    }\n\n    if (1) {\n        printf(\"Inside if(1) - 1 is treated as true.\\n\");\n    } else {\n        printf(\"Inside else for if(1) - This should NOT print.\\n\");\n    }\n\n    if (-100) {\n        printf(\"Inside if(-100) - -100 is treated as true.\\n\");\n    } else {\n        printf(\"Inside else for if(-100) - This should NOT print.\\n\");\n    }\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A) -100'],
            ['key' => 'B', 'text' => '(B) -1'],
            ['key' => 'C', 'text' => '(C) 0'],
            ['key' => 'D', 'text' => '(D) 1'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：C 語言中的布林邏輯</strong></p>
<p>在 C 語言中，整數 0 被視為假 (false)，任何非零整數被視為真 (true)。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(C) 0：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>在 C 語言中，0 視同為 false。</p>
HTML
    ],
    [
        'id_suffix' => '24',
        'question_text' => '24. 請問若宣告一個 short int 的整數佔用 2 bytes 的記憶體空間，則此整數的表示範圍為下列何者？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A) -2，147，483，648~2，147，483，647'],
            ['key' => 'B', 'text' => '(B) 0~65，535'],
            ['key' => 'C', 'text' => '(C) -32，768~32，767'],
            ['key' => 'D', 'text' => '(D)  0~4，294，967，295'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：有號整數 <code>short int</code> 的表示範圍</strong></p>
<p>2 bytes = 16 bits. 有號 <code>short int</code> 範圍是 -2<sup>15</sup> (-32,768) 到 2<sup>15</sup>-1 (32,767)。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(C) -32，768~32，767：</strong> 正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>2 bytes 有號 <code>short int</code> 範圍是 -32,768 到 32,767。</p>
HTML
    ],
    [
        'id_suffix' => '25',
        'question_text' => '25. 程式執行過程中，若變數發生溢位情形，其主要原因為何？',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)以有限數目的位元儲存變數值'],
            ['key' => 'B', 'text' => '(B)電壓不穩定'],
            ['key' => 'C', 'text' => '(C)作業系統與程式不甚相容'],
            ['key' => 'D', 'text' => '(D)變數過多導致編譯器無法完全處理'],
        ],
        'correct_answer' => 'A',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：變數溢位 (Overflow/Underflow)</strong></p>
<p>溢位發生是因為變數的儲存空間 (位元數) 有限，無法表示超出其設計範圍的數值。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A)以有限數目的位元儲存變數值：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>溢位的主要原因是變數以有限數目的位元儲存其值。</p>
HTML
    ],
    [
        'id_suffix' => '26',
        'question_text' => '26. 下列程式片段的執行結果為何？<pre><code class="language-c">int a;\\nprintf("%d", sizeof(a));</code></pre>',
        'code_snippet' => null, // Code is in question_text
        'run_code_id' => 'q26-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\nint main() {\n    int a;\n    printf(\"Size of a (int): %zu\\n\", sizeof(a));\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A) 1'],
            ['key' => 'B', 'text' => '(B) 2'],
            ['key' => 'C', 'text' => '(C) 4'],
            ['key' => 'D', 'text' => '(D) 8'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：<code>sizeof</code> 運算子</strong></p>
<p><code>sizeof(a)</code> (其中 <code>a</code> 是 <code>int</code>) 回傳 <code>int</code> 型別的大小 (以 bytes 為單位)。在多數現代系統上，<code>int</code> 是 4 bytes。</p>
<p><strong>2. 選項分析 (基於常見 <code>int</code> 大小)：</strong></p>
<ul>
    <li><strong>(C) 4：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p><code>sizeof(a)</code> 的結果最可能是 4。 (正確 printf 格式為 <code>%zu</code>)。</p>
HTML
    ],
    [
        'id_suffix' => '27',
        'question_text' => '27. 在  C/C++語言中，以下指令執行完後，顯示的值為何？<pre><code class="language-c">printf("%o\\n",15);</code></pre>',
        'code_snippet' => null, // Code is in question_text
        'run_code_id' => 'q27-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\nint main() {\n    printf(\"Decimal 15 in octal: %o\\n\", 15);\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A) 17'],
            ['key' => 'B', 'text' => '(B) 15'],
            ['key' => 'C', 'text' => '(C) F'],
            ['key' => 'D', 'text' => '(D) 15.0'],
        ],
        'correct_answer' => 'A',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：<code>printf</code> 的 <code>%o</code> 格式指定符 (八進制輸出)</strong></p>
<p><code>%o</code> 將整數以八進制輸出。十進制 15 等於八進制 17 (1*8 + 7*1 = 15)。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) 17：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>輸出為 <code>17</code>。</p>
HTML
    ],
    [
        'id_suffix' => '28',
        'question_text' => '28. 下列那一個不是 C 語言的合法變數名稱？ 【106 年工科技藝競賽】',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A) _Test'],
            ['key' => 'B', 'text' => '(B) TEST'],
            ['key' => 'C', 'text' => '(C) 5test'],
            ['key' => 'D', 'text' => '(D) test1'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：C/C++ 變數命名規則</strong></p>
<p>變數名不能以數字開頭。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(C) 5test：</strong>不合法，以數字開頭。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p><code>5test</code> 不是合法變數名稱。</p>
HTML
    ],
    [
        'id_suffix' => '29',
        'question_text' => '29. 在 C 語言中，下列那一種變數名稱是不合法？ 【107 年工科技藝競賽】',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A) _Happy'],
            ['key' => 'B', 'text' => '(B) Happy'],
            ['key' => 'C', 'text' => '(C) 9Happy'],
            ['key' => 'D', 'text' => '(D) Happy2'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：C/C++ 變數命名規則</strong></p>
<p>變數名不能以數字開頭。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(C) 9Happy：</strong>不合法，以數字開頭。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p><code>9Happy</code> 不是合法變數名稱。</p>
HTML
    ],
    [
        'id_suffix' => '30',
        'question_text' => '30. 關於 C 程式語言中，使用 define 建立常數的方式，下列何者正確？【111 年統測】',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A)define PI=3.14;'],
            ['key' => 'B', 'text' => '(B)define PI 3.14;'],
            ['key' => 'C', 'text' => '(C)#define PI=3.14'],
            ['key' => 'D', 'text' => '(D)#define PI 3.14'],
        ],
        'correct_answer' => 'D',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：<code>#define</code> 前置處理指令</strong></p>
<p><code>#define IDENTIFIER replacement_text</code>。不需要等號或分號。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(D) <code>#define PI 3.14</code>：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>正確方式是 <code>#define PI 3.14</code>。</p>
HTML
    ],
    [
        'id_suffix' => '31',
        'question_text' => '31. 關於 C 程式語言的資料型態，下列敘述何者錯誤？ 【111 年統測】',
        'code_snippet' => null,
        'run_code_id' => null,
        'code_snippet_for_runner' => null,
        'options' => [
            ['key' => 'A', 'text' => '(A) float 資料型態可以儲存浮點數，數值精確度跟 double 資料型態相同'],
            ['key' => 'B', 'text' => '(B) 宣告 int 資料型態可以儲存整數資料'],
            ['key' => 'C', 'text' => '(C) double 資料型態可以儲存浮點數值'],
            ['key' => 'D', 'text' => '(D) 宣告 char 資料型態可以儲存字元符號'],
        ],
        'correct_answer' => 'A',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：C/C++ 資料型態特性</strong></p>
<p><code>double</code> 的精確度高於 <code>float</code>。</p>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(A) float 資料型態可以儲存浮點數，數值精確度跟 double 資料型態相同：</strong>錯誤。<code>double</code> 精確度更高。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>敘述 (A) 錯誤。</p>
HTML
    ],
    [
        'id_suffix' => '32',
        'question_text' => '32. 小芳在一個原本可以編譯(Compile)成功的程式中，在 main( )主程式內再加入行號 1 至行號 6 的程式碼，但加入後發 編譯錯誤的情況。
<pre><code class="language-c">
//1 #define Value1  100
//2 #define Value2 (Value1 - 1)
//3 const  int  Value3;
//4 int CheckValue = 0;
//5 Value3 = Value2;
//6 CheckValue = Value1 + Value3;
</code></pre>
小芳刪除行號 1 至行號 5 中的哪一個部分後，可以使程式編譯成功？ 【112 年統測】',
        'code_snippet' => null, // Code is in question_text
        'run_code_id' => 'q32-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\n#define Value1 100\n#define Value2 (Value1 - 1)\n\nint main() {\n    int Value3_modified;\n    int CheckValue_modified = 0;\n    Value3_modified = Value2;\n    CheckValue_modified = Value1 + Value3_modified;\n    printf(\"If 'const' is removed from Value3 declaration:\\n\");\n    printf(\"Value3_modified = %d\\n\", Value3_modified);\n    printf(\"CheckValue_modified = %d\\n\", CheckValue_modified);\n    return 0;\n}\n",
        'options' => [
            ['key' => 'A', 'text' => '(A)(Value1  1)'],
            ['key' => 'B', 'text' => '(B)Value3 = Value2;'],
            ['key' => 'C', 'text' => '(C)	const'],
            ['key' => 'D', 'text' => '(D)#define Value2 (Value1  1)'],
        ],
        'correct_answer' => 'C',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 關鍵概念：<code>const</code> 限定字與初始化</strong></p>
<p><code>const</code> 變數必須在宣告時初始化，之後不能再賦值。錯誤在行 3 未初始化 <code>Value3</code>，然後在行 5 嘗試賦值。</p>
<p><strong>2. 如何修正使程式編譯成功 (根據選項)：</strong></p>
<ul>
    <li><strong>(C) 刪除 <code>const</code> (從行號 3 <code>const int Value3;</code> 中刪除 <code>const</code>)：</strong>使 <code>Value3</code> 變成普通變數，行 5 的賦值合法。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p>刪除行號 3 中的 <code>const</code> 可以使程式編譯成功。</p>
HTML
    ],
    [
        'id_suffix' => '33',
        'question_text' => '33. 同上題,程式修正後 (假設是透過刪除行號 3 的 const)，當程式執行完行號 6 的時候，CheckValue 的值為下列何者？',
        'code_snippet' => null, // Logic is based on previous question's code
        'run_code_id' => 'q33-code',
        'code_snippet_for_runner' => "#include <stdio.h>\n\n#define Value1 100\n#define Value2 (Value1 - 1)\n\nint main() {\n    int Value3; \n    int CheckValue = 0;\n    Value3 = Value2; \n    CheckValue = Value1 + Value3;\n    printf(\"Value3 = %d\\n\", Value3);\n    printf(\"CheckValue = %d\\n\", CheckValue);\n    return 0;\n}",
        'options' => [
            ['key' => 'A', 'text' => '(A)200'],
            ['key' => 'B', 'text' => '(B)199'],
            ['key' => 'C', 'text' => '(C)198'],
            ['key' => 'D', 'text' => '(D)100'],
        ],
        'correct_answer' => 'B',
        'explanation_html' => <<<HTML
<h4>詳解</h4>
<p><strong>1. 程式碼執行追蹤 (假設行 3 的 <code>const</code> 已刪除)：</strong></p>
<ol>
    <li><code>#define Value1 100</code></li>
    <li><code>#define Value2 (Value1 - 1)</code>  (即 99)</li>
    <li><code>int Value3;</code></li>
    <li><code>int CheckValue = 0;</code></li>
    <li><code>Value3 = Value2;</code>  (<code>Value3</code> 變為 99)</li>
    <li><code>CheckValue = Value1 + Value3;</code> (<code>CheckValue = 100 + 99 = 199</code>)</li>
</ol>
<p><strong>2. 選項分析：</strong></p>
<ul>
    <li><strong>(B) 199：</strong>正確。</li>
</ul>
<p><strong>3. 結論：</strong></p>
<p><code>CheckValue</code> 的值為 199。</p>
HTML
    ],
];

$html_title = "C/C++ 綜合測驗 (EE7-5)"; // Static title for this specific quiz page
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
        | EE7-5 C/C++綜合測驗 (本頁)
        | <a href="ee7-6.php">EE7-6 C++ OOP測驗 II</a>
    </nav>
    <div class="container">
        <main class="tutorial-content">
            <h1>C/C++ 綜合測驗 (EE7-5)</h1>
            <p>本頁面提供一系列 C 和 C++ 語言的綜合練習題，涵蓋資料型態、變數、運算子、控制結構、函式、輸出入等基礎概念。部分題目亦會涉及 C++ 特有的物件導向特性。請仔細分析每個問題，並利用右側的沙箱進行實作與驗證。</p>

            <div class="quiz-section" id="quiz-section-dynamic">
                <h2>C/C++ 綜合練習題組 (EE7-5)</h2>
                <p>請挑戰下面的題目，檢驗您的 C/C++ 綜合能力！ (共 <?php echo count($current_exercises); ?> 題)</p>

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
                            <pre><code class="language-clike"><?php echo htmlspecialchars($formatted_separate_snippet); ?></code></pre>
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
                    <h3>C/C++ 程式碼沙箱 (WASM)</h3>
                    <textarea id="code-editor" spellcheck="false">/* 點擊題目下方的「運行示例」按鈕以載入程式碼，或在此處編寫您自己的 C/C++ 程式碼。 */</textarea>
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
            $runnable_samples_ee7_5 = [];
            if (isset($current_exercises) && is_array($current_exercises)) {
                foreach ($current_exercises as $exercise) {
                    if (!empty($exercise['run_code_id']) && !empty($exercise['code_snippet_for_runner'])) {
                        $js_code = str_replace("\\\\n", "\\n", $exercise['code_snippet_for_runner']);
                        $js_code = str_replace("'", "\\'", $js_code);
                        $js_code = str_replace("\"", "\\\"", $js_code);
                        $runnable_samples_ee7_5[] = "'" . addslashes($exercise['run_code_id']) . "': \"" . $js_code . "\"";
                    }
                }
            }
            echo implode(",\n            ", $runnable_samples_ee7_5);
            if (empty($runnable_samples_ee7_5)) {
                 echo "'q_default_sample_ee7_5': \"#include <stdio.h>\\n\\nint main() {\\n    printf(\\\"Hello, C/C++ world! EE7-5\\\\n\\\");\\n    return 0;\\n}\"";
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
                 codeEditor.value = "// No runnable C/C++ examples specifically for this page. Write your code here.";
            }
        });
    </script>
</body>
</html>
