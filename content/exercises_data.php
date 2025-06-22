<?php

$all_exercises = [
    'chapter2' => [
        [
            'id' => 'ch2_ex1',
            'question' => '下列何者不是C語言的關鍵字？',
            'options' => [
                'A) int',
                'B) main',
                'C) for',
                'D) sizeof'
            ],
            'correct_option_index' => 1, // B) main
            'code_snippet' => null,
            'explanation' => [
                'knowledge_point' => 'C語言關鍵字與識別字',
                'detailed_analysis' => '關鍵字是C語言中具有特殊意義的保留字，不能被用作識別字（如變數名、函式名）。<br>
                                       `int` 用於宣告整數型態變數。<br>
                                       `for` 是迴圈控制結構的關鍵字。<br>
                                       `sizeof` 是一個運算子，用於取得資料型態或變數的大小，它也是一個關鍵字。<br>
                                       `main` 雖然是每個C程式都需要的函式名稱，代表程式的進入點，但它本身並非C語言標準定義的「關鍵字」。它可以被視為一個具有特殊約定用途的識別字。然而，在某些上下文中，如果題目旨在區分保留字和普通標識符，`main` 相對於其他選項更不像一個嚴格意義上的“語法”關鍵字。更準確地說，`main` 是連結器在尋找程式起點時所依賴的特定函式名。',
                'code_line_comments' => null,
                'wrong_options' => [
                    'A' => '`int` 是C語言的關鍵字，用於宣告整數型態。',
                    'C' => '`for` 是C語言的關鍵字，用於 `for` 迴圈結構。',
                    'D' => '`sizeof` 是C語言的關鍵字，也是一個運算子，用於計算型態或變數所佔的記憶體大小。'
                ]
            ]
        ],
        [
            'id' => 'ch2_ex2',
            'question' => '關於以下程式碼，何者敘述正確？',
            'options' => [
                'A) `stdio.h` 是使用者自訂的標頭檔。',
                'B) `main` 函式是程式的唯一入口點。',
                'C) `printf` 只能輸出一行文字。',
                'D) `return 0;` 表示程式執行時發生錯誤。'
            ],
            'correct_option_index' => 1, // B
            'code_snippet' => "#include <stdio.h>\n\nint main() {\n    printf(\"Hello C!\\n\");\n    return 0;\n}",
            'explanation' => [
                'knowledge_point' => 'C程式基本結構、標準函式庫、main函式、printf函式',
                'detailed_analysis' => '這是一個標準的 "Hello World" C程式，展示了C程式的基本組成部分。',
                'code_line_comments' => [
                    '#include <stdio.h>' => '引入標準輸入輸出標頭檔，提供如 `printf` 等函式的宣告。尖括號表示尋找系統預設路徑下的標頭檔。',
                    'int main() {' => '`main` 函式是C程式執行的起點。`int` 表示 `main` 函式執行完畢後會回傳一個整數值給作業系統。',
                    '    printf("Hello C!\\n");' => '`printf` 是標準輸出函式，用於將字串或格式化資料輸出到螢幕。`\\n` 是換行符。',
                    '    return 0;' => '表示 `main` 函式正常結束，並回傳0給作業系統。一般約定，回傳0代表成功，非0代表失敗。',
                    '}' => '`main` 函式結束。'
                ],
                'wrong_options' => [
                    'A' => '`stdio.h` 是C語言的標準庫標頭檔，不是使用者自訂的。使用者自訂的標頭檔通常用雙引號 `""` 引入。',
                    'C' => '`printf` 可以透過多個呼叫或在一個呼叫中使用多個 `\\n` 來輸多行文字。',
                    'D' => '在 `main` 函式中，`return 0;` 通常表示程式成功執行並正常結束。回傳非零值（例如 `return 1;`）才表示可能發生了錯誤。'
                ]
            ]
        ],
        // ... 更多第二章的練習題 ...
        // 假設的第三題
        [
            'id' => 'ch2_ex3',
            'question' => 'C語言程式的副檔名通常是什麼？',
            'options' => [
                'A) .cpp',
                'B) .java',
                'C) .c',
                'D) .py'
            ],
            'correct_option_index' => 2, // C
            'code_snippet' => null,
            'explanation' => [
                'knowledge_point' => 'C語言檔案命名慣例',
                'detailed_analysis' => 'C語言的原始程式碼檔案通常使用 `.c` 作為其副檔名。這有助於編譯器和其他工具識別檔案類型。',
                'code_line_comments' => null,
                'wrong_options' => [
                    'A' => '`.cpp` 通常是 C++ 語言原始程式碼檔案的副檔名。',
                    'B' => '`.java` 是 Java 語言原始程式碼檔案的副檔名。',
                    'D' => '`.py` 是 Python 語言腳本檔案的副檔名。'
                ]
            ]
        ]
    ],
    'chapter3' => [
        // 第三章的練習題將在此處添加
        [
            'id' => 'ch3_ex1',
            'question' => '下列何者不是C語言的有效整數資料型態關鍵字？',
            'options' => [
                'A) char',
                'B) integer',
                'C) short',
                'D) long long'
            ],
            'correct_option_index' => 1, // B
            'code_snippet' => null,
            'explanation' => [
                'knowledge_point' => 'C語言整數資料型態',
                'detailed_analysis' => 'C語言提供多種整數資料型態來儲存不同範圍的整數值。這些型態由特定的關鍵字表示。',
                'code_line_comments' => null,
                'wrong_options' => [
                    'A' => '`char` 是C語言的關鍵字，用於表示字元型態，它本質上也是一種小型整數型態。',
                    'C' => '`short` (或 `short int`) 是C語言的關鍵字，用於表示短整數型態。',
                    'D' => '`long long` (或 `long long int`) 是C99標準引入的關鍵字，用於表示長長整數型態，提供更大的整數儲存範圍。',
                ],
                // 對於正確選項的補充說明
                'B' => '`integer` 並非C語言的標準關鍵字。表示整數的主要關鍵字是 `int`。雖然 "integer" 是 "整數" 的英文，但它不是C的語法。'
            ]
        ]
    ],
    'chapter4' => [], // 預留
    'chapter5' => [], // 預留
    'chapter6' => [], // 預留
    'chapter7' => [], // 預留
];

// 為了方便在 index.php 中使用，可以提供一個函式來獲取特定章節的練習題
function get_exercises_for_chapter($chapter_key) {
    global $all_exercises;
    return isset($all_exercises[$chapter_key]) ? $all_exercises[$chapter_key] : [];
}

?>
