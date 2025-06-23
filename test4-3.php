<?php
// --- 資料區 ---
// 將所有測驗題目、選項、答案與詳解以一個PHP陣列儲存。
// 這種結構使得未來維護、新增或刪除題目變得非常容易。
// 已包含 test4-txt-OK.txt 中所有題目，並以 ANSI C 標準修正。
$quizData = [
    // 題號 4
    [
        'question' => '(題號 4) 當下列程式片段執行完畢後，變數 x 的數值為何？',
        'code' => '#include <stdio.h>

int main() {
    int n = 0;
    int x = 0;
    do {
        x += n;
        n++;
    } while (n < 10);

    printf("x = %d\\n", x);
    return 0;
}',
        'options' => ['A' => '50', 'B' => '45', 'C' => '30', 'D' => '20'],
        'answer' => 'B',
        'explanation' => '此程式碼使用 `do-while` 迴圈計算從 0 到 9 的整數總和。變數 `x` 用於累加，`n` 作為計數器。',
        'trace' => [
            'headers' => ['迴圈開始前 n', '執行 x += n', '執行 n++', '迴圈結束後 n', '條件檢查 (n < 10)'],
            'rows' => [
                ['0', 'x = 0 + 0 = 0', 'n = 1', '1', 'true'],
                ['1', 'x = 0 + 1 = 1', 'n = 2', '2', 'true'],
                ['2', 'x = 1 + 2 = 3', 'n = 3', '3', 'true'],
                ['3', 'x = 3 + 3 = 6', 'n = 4', '4', 'true'],
                ['4', 'x = 6 + 4 = 10', 'n = 5', '5', 'true'],
                ['5', 'x = 10 + 5 = 15', 'n = 6', '6', 'true'],
                ['6', 'x = 15 + 6 = 21', 'n = 7', '7', 'true'],
                ['7', 'x = 21 + 7 = 28', 'n = 8', '8', 'true'],
                ['8', 'x = 28 + 8 = 36', 'n = 9', '9', 'true'],
                ['9', 'x = 36 + 9 = 45', 'n = 10', '10', 'false (迴圈終止)']
            ]
        ],
        'conclusion' => '當 `n` 增加到 10 時，`while` 條件 `(10 < 10)` 判斷為 false，迴圈結束。最終 `x` 的值是 0 到 9 的總和，即 45。'
    ],
    // 題號 5
    [
        'question' => '(題號 5) 下列程式碼，while 迴圈內 i = i * i 被執行多少次？',
        'code' => '#include <stdio.h>

int main() {
    int i = 2;
    while (i < 800) {
        i = i * i;
    }
    // 迴圈結束後 i 的值會是 65536
    return 0;
}',
        'options' => ['A' => '2', 'B' => '3', 'C' => '4', 'D' => '5'],
        'answer' => 'C',
        'explanation' => '這個迴圈的終止條件是變數 `i` 的值大於等於 800。我們來追蹤 `i` 的值如何快速成長。',
        'trace' => [
            'headers' => ['執行次數', '迴圈開始前 i 的值', '條件檢查 (i < 800)', '執行 i = i * i', '迴圈結束後 i 的值'],
            'rows' => [
                ['1', '2', 'true', 'i = 2 * 2', '4'],
                ['2', '4', 'true', 'i = 4 * 4', '16'],
                ['3', '16', 'true', 'i = 16 * 16', '256'],
                ['4', '256', 'true', 'i = 256 * 256', '65536'],
                ['-', '65536', 'false (迴圈終止)', '-', '-']
            ]
        ],
        'conclusion' => '在第 4 次執行 `i = i * i` 後，`i` 的值變為 65536，此時 `65536 < 800` 條件為 false，迴圈結束。因此，迴圈體總共執行了 4 次。'
    ],
    // 題號 10
    [
        'question' => '(題號 10) 執行下列程式碼之後，請問最後 s 的值多少？',
        'code' => '#include <stdio.h>

int main() {
    int s = 0;
    // ANSI C 標準建議在 for 迴圈外宣告變數 i
    int i;
    for (i = 2; i <= 100; i += 2) {
        s += i;
    }
    printf("s = %d\\n", s);
    return 0;
}',
        'options' => ['A' => '5500', 'B' => '2550', 'C' => '5050', 'D' => '2500'],
        'answer' => 'B',
        'explanation' => '此程式碼計算從 2 到 100 之間所有偶數的總和。這是一個等差數列求和問題。
        <br><b>首項 (a1):</b> 2, <b>末項 (an):</b> 100, <b>公差 (d):</b> 2
        <br><b>項數 (n):</b> (末項 - 首項) / 公差 + 1 = (100 - 2) / 2 + 1 = 50 項
        <br><b>總和公式 (S):</b> (首項 + 末項) * 項數 / 2',
        'trace' => [
            'headers' => ['計算過程', '結果'],
            'rows' => [
                ['(2 + 100) * 50 / 2', ''],
                ['102 * 50 / 2', ''],
                ['5100 / 2', ''],
                ['2550', '✅']
            ]
        ],
        'conclusion' => '因此，`s` 的最終值為 2550。'
    ],
    // 題號 18
    [
        'question' => '(題號 18) 執行下列 C 程式片段，請問最後輸出是？ (已修正為 ANSI C 標準)',
        'code' => '#include <stdio.h>

int main() {
    int number = 1061130, result;
    do {
        result = number % 10;
        printf("%d", result); // %i 修正為 %d
        number = number / 10;
    } while (number != 0);

    printf("\\n");
    return 0;
}',
        'options' => ['A' => '1061130', 'B' => '0311601', 'C' => '106113', 'D' => '311601'],
        'answer' => 'B',
        'explanation' => '此程式使用 `do-while` 迴圈，透過取餘數 (`% 10`) 和整數除法 (`/ 10`) 的方式，從個位數開始，逐一印出一個整數的每一位，進而實現數字反轉的效果。',
        'trace' => [
            'headers' => ['迴圈開始前 number', 'result = number % 10', '輸出 (printf)', 'number = number / 10', '條件 (number != 0)'],
            'rows' => [
                ['1061130', '0', '0', '106113', 'true'],
                ['106113', '3', '3', '10611', 'true'],
                ['10611', '1', '1', '1061', 'true'],
                ['1061', '1', '1', '106', 'true'],
                ['106', '6', '6', '10', 'true'],
                ['10', '0', '0', '1', 'true'],
                ['1', '1', '1', '0', 'false (迴圈終止)']
            ]
        ],
        'conclusion' => '迴圈從 `number` 的個位數開始印，直到 `number` 變為 0。因此，最終螢幕上的輸出組合起來就是 `0311601`。'
    ],
    // 題號 27
    [
        'question' => '(題號 27) 執行下列程式碼後，請問輸出結果為？',
        'code' => '#include <stdio.h>

int main() {
    int x = 0, y = 0;
    for (y = 1; y <= 20; y++) {
        int z = y % 5;
        if (z == 0) {
            x++;
        }
    }
    printf("%3d%3d\\n", x, y);
    return 0;
}',
        'options' => ['A' => '0 0', 'B' => '4 21', 'C' => '2 11', 'D' => '3 11'],
        'answer' => 'B',
        'explanation' => '此 `for` 迴圈會執行 20 次 (從 `y=1` 到 `y=20`)。它會檢查 `y` 是否為 5 的倍數，如果是，則將計數器 `x` 的值加 1。迴圈結束後，會印出 `x` 和 `y` 的最終值。',
        'trace' => [
            'headers' => ['y 的值', 'z = y % 5', 'if (z == 0)', 'x 的值 (變化後)'],
            'rows' => [
                ['1...4', '1...4', 'false', '0 (無變化)'],
                ['5', '0', 'true', '1'],
                ['6...9', '1...4', 'false', '1 (無變化)'],
                ['10', '0', 'true', '2'],
                ['11...14', '1...4', 'false', '2 (無變化)'],
                ['15', '0', 'true', '3'],
                ['16...19', '1...4', 'false', '3 (無變化)'],
                ['20', '0', 'true', '4']
            ]
        ],
        'conclusion' => '迴圈在 `y` 為 5, 10, 15, 20 時，`x` 會遞增，所以迴圈結束後 `x` 的值為 4。<br><b>關鍵點：</b>`for` 迴圈的條件判斷在迴圈體執行之前。當 `y` 為 20 時，迴圈體最後一次執行完，`y` 執行 `y++` 變成 21，此時條件 `21 <= 20` 為 false，迴圈才正式終止。所以 `printf` 被執行時，`y` 的值是 21。最終輸出為 `  4 21`。'
    ],
    // 題號 28
    [
        'question' => '(題號 28) 請問下列程式執行後，輸出結果為何？',
        'code' => '#include <stdio.h>

int main() {
    int i;
    for(i=1; i<10; i=i+3) {
        i++;
    }
    printf("%d\\n", i);
    return 0;
}',
        'options' => ['A' => '10', 'B' => '11', 'C' => '12', 'D' => '13'],
        'answer' => 'D',
        'explanation' => '這個 `for` 迴圈的計數器 `i` 在兩個地方被改變：迴圈主體中的 `i++` 和迴圈更新敘述中的 `i=i+3`。我們必須仔細追蹤它的每一步。',
        'trace' => [
            'headers' => ['迴圈開始前 i', '條件檢查 (i<10)', '執行迴圈主體 (i++)', '執行更新敘述 (i=i+3)', '迴圈結束後 i'],
            'rows' => [
                ['1', 'true', 'i 變為 2', 'i = 2 + 3', '5'],
                ['5', 'true', 'i 變為 6', 'i = 6 + 3', '9'],
                ['9', 'true', 'i 變為 10', 'i = 10 + 3', '13'],
                ['13', 'false (迴圈終止)', '-', '-', '13']
            ]
        ],
        'conclusion' => '當 `i` 變為 13 後，條件 `13 < 10` 為 false，迴圈終止。此時 `printf` 會印出 `i` 的最終值，即 13。'
    ],
    // 題號 30
    [
        'question' => '(題號 30) 執行下列程式片段，結果為何？',
        'code' => '#include <stdio.h>

int main() {
    int i = 10;
    do {
        i = i - 1;
        printf("%d", i);
    } while(0); // 條件永遠為 false

    printf("\\n");
    return 0;
}',
        'options' => ['A' => '10', 'B' => '9', 'C' => '8', 'D' => '此迴圈為無窮迴圈'],
        'answer' => 'B',
        'explanation' => '`do-while` 迴圈的關鍵特性是：不論條件是否成立，它的迴圈主體至少會執行一次。',
        'trace' => [
            'headers' => ['步驟', 'i 的值', '執行動作', '條件檢查 (while(0))'],
            'rows' => [
                ['1. 進入迴圈主體', '10', '執行 `i = i - 1;`', 'i 變為 9'],
                ['2. 輸出', '9', '執行 `printf("%d", i);`', '螢幕印出 9'],
                ['3. 檢查條件', '9', '`while(0)` 為 false', '迴圈終止']
            ]
        ],
        'conclusion' => '因為 `do-while` 迴圈先執行、後判斷，所以迴圈主體執行了一次，印出 9，然後因條件為 false 而結束。'
    ],
    // 題號 34
    [
        'question' => '(題號 34) 執行下列程式片段後，sum 的值為何?',
        'code' => '#include <stdio.h>

int main() {
    int i, j, sum = 0;
    for (i = 1; i < 3; i++) {
        for (j = 1; j < 3; j++) {
            sum = sum + j;
        }
    }
    printf("%d\\n", sum);
    return 0;
}',
        'options' => ['A' => '4', 'B' => '5', 'C' => '6', 'D' => '7'],
        'answer' => 'C',
        'explanation' => '這是一個巢狀迴圈。外層迴圈每執行一次，內層迴圈就會完整地執行一輪。',
        'trace' => [
            'headers' => ['外層迴圈 (i)', '內層迴圈 (j)', '執行 sum = sum + j', 'sum 的值'],
            'rows' => [
                ['i=1 (開始)', '-', '-', '0'],
                ['', 'j=1', 'sum = 0 + 1', '1'],
                ['', 'j=2', 'sum = 1 + 2', '3'],
                ['', 'j=3 (條件 j<3 為 false)', '內層迴圈結束', '3'],
                ['i=2 (開始)', '-', '-', '3'],
                ['', 'j=1', 'sum = 3 + 1', '4'],
                ['', 'j=2', 'sum = 4 + 2', '6'],
                ['', 'j=3 (條件 j<3 為 false)', '內層迴圈結束', '6'],
                ['i=3 (條件 i<3 為 false)', '-', '外層迴圈結束', '6']
            ]
        ],
        'conclusion' => '外層迴圈跑了 2 次 (i=1, i=2)，每次內層迴圈都將 `sum` 加上 `1+2=3`。第一次後 `sum` 為 3，第二次後 `sum` 為 `3 + 3 = 6`。最終 `sum` 的值為 6。'
    ],
];

// --- 程式碼開始 ---
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C語言互動選擇題 - 迴圈練習 (完整修正版)</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>

    <script>
    MathJax = {
      tex: { inlineMath: [['$', '$'], ['\\(', '\\)']] },
      svg: { fontCache: 'global' }
    };
    </script>
    <script type="text/javascript" id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js"></script>

    <style>
        :root {
            --background-color: #1e1e1e; --text-color: #d4d4d4; --primary-color: #007acc;
            --container-bg: #252526; --border-color: #3c3c3c; --header-bg: #333333;
            --button-bg: #0e639c; --button-hover-bg: #007acc; --correct-bg: rgba(45, 211, 111, 0.1);
            --correct-border: #2dd36f; --incorrect-bg: rgba(235, 68, 90, 0.1); --incorrect-border: #eb445a;
            --splitter-color: #505050;
        }
        body { font-family: 'Segoe UI', 'Microsoft JhengHei', sans-serif; margin: 0; background-color: var(--background-color); color: var(--text-color); display: flex; flex-direction: column; height: 100vh; overflow: hidden; }
        .header { background-color: var(--header-bg); padding: 10px 20px; border-bottom: 2px solid var(--primary-color); display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }
        .header h1 { margin: 0; font-size: 1.5em; }
        .container { display: flex; flex-grow: 1; overflow: hidden; }
        .main-content { padding: 20px; overflow-y: auto; width: 70%; flex-shrink: 0; box-sizing: border-box; }
        .splitter { width: 8px; background-color: var(--splitter-color); cursor: col-resize; flex-shrink: 0; }
        .ide-container { display: flex; flex-direction: column; width: 30%; flex-shrink: 0; background-color: var(--container-bg); padding: 10px; box-sizing: border-box; }
        .quiz-container { max-width: 800px; margin: 0 auto; }
        .question-card { background-color: var(--container-bg); border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 25px; padding: 25px; display: none; }
        .question-card.active { display: block; }
        .question-title { font-size: 1.2em; margin-bottom: 15px; font-weight: 600; }
        pre[class*="language-"] { border-radius: 6px; padding: 1.2em !important; margin: 20px 0 !important; box-shadow: 0 4px 10px rgba(0,0,0,0.3); border: 1px solid #4a4a4a; }
        .options-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-top: 20px; }
        .option { background-color: #333; padding: 15px; border: 2px solid transparent; border-radius: 5px; cursor: pointer; transition: all 0.2s ease-in-out; display: flex; align-items: center; }
        .option:hover { border-color: var(--primary-color); }
        .option.selected { border-color: #9cdcfe; background-color: #3a3d41; }
        .option input[type="radio"] { display: none; }
        .option .option-label { font-weight: bold; margin-right: 10px; color: var(--primary-color); }
        .explanation { margin-top: 25px; padding: 20px; border-radius: 6px; display: none; border-left: 5px solid; }
        .explanation.correct { background-color: var(--correct-bg); border-color: var(--correct-border); }
        .explanation.incorrect { background-color: var(--incorrect-bg); border-color: var(--incorrect-border); }
        .explanation-title { font-weight: bold; font-size: 1.1em; margin-bottom: 10px; }
        .trace-table { width: 100%; border-collapse: collapse; margin: 15px 0; font-size: 0.9em; }
        .trace-table th, .trace-table td { border: 1px solid var(--border-color); padding: 8px 12px; text-align: center; }
        .trace-table th { background-color: #3e3e42; font-weight: 600; }
        .trace-table td { background-color: #2d2d30; font-family: 'Consolas', 'Menlo', monospace; }
        .trace-table tr:nth-child(even) td { background-color: #333337; }
        .trace-table b { color: #9cdcfe; }
        .conclusion { margin-top: 15px; padding: 10px; background-color: rgba(0, 122, 204, 0.15); border-left: 3px solid var(--primary-color); border-radius: 4px; }
        .navigation { margin-top: 20px; display: flex; justify-content: center; align-items: center; }
        .nav-button { background-color: var(--button-bg); color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-size: 1em; transition: background-color 0.2s; display: none; }
        .nav-button:hover { background-color: var(--button-hover-bg); }
        #editor { height: 60%; width: 100%; border-radius: 5px; }
        #output-container { flex-grow: 1; margin-top: 10px; background: #1a1a1a; color: #f1f1f1; padding: 10px; border-radius: 5px; overflow-y: auto; font-family: 'Consolas', 'Menlo', monospace; white-space: pre-wrap; border: 1px solid var(--border-color); }
        .ide-controls { margin: 10px 0; display: flex; gap: 10px; }
        .ide-button { background-color: #3e8e41; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.2s; }
        .ide-button:hover { background-color: #4caf50; }
    </style>
</head>
<body>
    <header class="header">
        <h1>C語言互動選擇題 - 迴圈 (完整修正版)</h1>
    </header>
    <div class="container">
        <div class="main-content">
            <div class="quiz-container">
                <?php foreach ($quizData as $index => $q): ?>
                    <div class="question-card" id="q<?php echo $index; ?>" data-answer="<?php echo $q['answer']; ?>">
                        <div class="question-title"><?php echo $q['question']; ?></div>
                        <pre><code class="language-c"><?php echo htmlspecialchars($q['code']); ?></code></pre>
                        <div class="options-grid">
                            <?php foreach ($q['options'] as $key => $optionText): ?>
                                <label class="option" for="q<?php echo $index; ?>_<?php echo $key; ?>">
                                    <input type="radio" name="q<?php echo $index; ?>" id="q<?php echo $index; ?>_<?php echo $key; ?>" value="<?php echo $key; ?>">
                                    <span class="option-label"><?php echo $key; ?></span>
                                    <span><?php echo htmlspecialchars($optionText); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <div class="explanation">
                            <div class="explanation-title"></div>
                            <p><?php echo $q['explanation']; ?></p>
                            <?php if (isset($q['trace']) && !empty($q['trace']['rows'])): ?>
                                <table class="trace-table">
                                    <thead>
                                        <tr><?php foreach ($q['trace']['headers'] as $header): ?><th><?php echo $header; ?></th><?php endforeach; ?></tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($q['trace']['rows'] as $row): ?>
                                            <tr><?php foreach ($row as $cell): ?><td><?php echo $cell; ?></td><?php endforeach; ?></tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                            <?php if (isset($q['conclusion'])): ?>
                                <div class="conclusion"><?php echo $q['conclusion']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="navigation">
                    <button id="next-btn" class="nav-button">下一題</button>
                </div>
            </div>
        </div>
        <div class="splitter" id="splitter"></div>
        <div class="ide-container">
             <div id="editor">// 在這裡嘗試您的C程式碼...
#include <stdio.h>

int main() {
    printf("Hello, World!\\n");
    return 0;
}
</div>
            <div class="ide-controls">
                <button id="run-btn" class="ide-button">▶ 執行</button>
                <button id="clear-output-btn" class="ide-button" style="background-color:#c9302c;">清除輸出</button>
            </div>
            <pre id="output-container">輸出結果將顯示在這裡...</pre>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.15.2/ace.js"></script>
    <script>
        let editor = ace.edit("editor");
        editor.setTheme("ace/theme/tomorrow_night");
        editor.session.setMode("ace/mode/c_cpp");
        const outputContainer = document.getElementById('output-container');

        async function runCode(code) {
             outputContainer.textContent = "正在編譯與執行...\n";
             try {
                const response = await fetch("https://emkc.org/api/v2/piston/execute", {
                    method: "POST", headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ language: "c", version: "10.2.0", files: [{ name: "main.c", content: code }] })
                });
                const result = await response.json();
                if (result.run && result.run.stdout) { return result.run.stdout; }
                if (result.compile && result.compile.stderr) { return `編譯錯誤:\n${result.compile.stderr}`; }
                if (result.run && result.run.stderr) { return `執行錯誤:\n${result.run.stderr}`; }
                return "執行完畢，但沒有輸出。";
             } catch (error) { return `執行時發生錯誤: ${error.message}`; }
        }

        document.getElementById('run-btn').addEventListener('click', async () => {
            outputContainer.textContent = await runCode(editor.getValue());
        });
        document.getElementById('clear-output-btn').addEventListener('click', () => {
            outputContainer.textContent = "輸出結果將顯示在這裡...";
        });

        const questions = document.querySelectorAll('.question-card');
        const nextBtn = document.getElementById('next-btn');
        let currentQuestionIndex = 0;
        const totalQuestions = <?php echo count($quizData); ?>;

        function showQuestion(index) {
            questions.forEach((q, i) => q.classList.toggle('active', i === index));
            nextBtn.style.display = 'none';
            nextBtn.textContent = (index >= totalQuestions - 1) ? '完成測驗' : '下一題';
        }

        questions.forEach(card => {
            const options = card.querySelectorAll('.option');
            const explanation = card.querySelector('.explanation');
            options.forEach(option => {
                option.addEventListener('click', () => {
                    if (card.dataset.answered) return;
                    card.dataset.answered = 'true';
                    options.forEach(opt => opt.classList.remove('selected'));
                    option.classList.add('selected');
                    const selectedAnswer = option.querySelector('input').value;
                    const correctAnswer = card.dataset.answer;
                    const explanationTitle = explanation.querySelector('.explanation-title');
                    if (selectedAnswer === correctAnswer) {
                        explanation.classList.add('correct');
                        explanationTitle.textContent = '✅ 正確！';
                    } else {
                        explanation.classList.add('incorrect');
                        explanationTitle.textContent = '❌ 錯誤！正確答案是 ' + correctAnswer;
                    }
                    explanation.style.display = 'block';
                    nextBtn.style.display = 'inline-block';
                });
            });
        });

        nextBtn.addEventListener('click', () => {
            currentQuestionIndex++;
            if (currentQuestionIndex < totalQuestions) {
                showQuestion(currentQuestionIndex);
            } else {
                alert('您已完成所有題目！');
                window.location.reload();
            }
        });
        showQuestion(0);

        const splitter = document.getElementById('splitter');
        const mainContent = document.querySelector('.main-content');
        let isDragging = false;
        splitter.addEventListener('mousedown', e => {
            e.preventDefault(); isDragging = true;
            document.body.style.cursor = 'col-resize';
            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        });
        function onMouseMove(e) {
            if (!isDragging) return;
            const containerRect = splitter.parentElement.getBoundingClientRect();
            const newLeftWidth = e.clientX - containerRect.left;
            if (newLeftWidth > 200 && newLeftWidth < containerRect.width - 200) {
                 const newLeftPercent = (newLeftWidth / containerRect.width) * 100;
                 mainContent.style.width = `${newLeftPercent}%`;
                 document.querySelector('.ide-container').style.width = `${100 - newLeftPercent}%`;
                 editor.resize();
            }
        }
        function onMouseUp() {
            isDragging = false; document.body.style.cursor = 'default';
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
        }
    </script>
</body>
</html>
