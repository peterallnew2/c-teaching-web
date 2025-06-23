<?php
// --- 資料區 ---
// 將所有測驗題目、選項、答案與詳解以一個PHP陣列儲存。
// 這種結構使得未來維護、新增或刪除題目變得非常容易。
$quizData = [
    [
        'question' => '(題號 4) 當下列程式片段執行完畢後，變數 x 的數值為何？ ',
        'code' => 'int n = 0;
int x = 0;
do {
    x += n;
    n++;
} while (n < 10);',
        'options' => [
            'A' => '50',
            'B' => '45',
            'C' => '30',
            'D' => '20'
        ],
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
        'conclusion' => '當 `n` 增加到 10 時，`while` 條件 `(10 < 10)` 判斷為 false，迴圈結束。最終 `x` 的值是 0 到 9 的總和，即 45。 '
    ],
    [
        'question' => '(題號 5) 下列程式碼，while 迴圈內 i = i * i 被執行多少次？ ',
        'code' => 'int i = 2;
while (i < 800) {
    i = i * i;
}',
        'options' => [
            'A' => '2',
            'B' => '3',
            'C' => '4',
            'D' => '5'
        ],
        'answer' => 'C',
        'explanation' => '這個迴圈的終止條件是變數 `i` 的值大於等於 800。我們來追蹤 `i` 的值如何快速成長。 ',
        'trace' => [
            'headers' => ['執行次數', '迴圈開始前 i 的值', '條件檢查 (i < 800)', '執行 i = i * i', '迴圈結束後 i 的值'],
            'rows' => [
                ['1', '2', 'true', 'i = 2 * 2', '4'],
                ['2', '4', 'true', 'i = 4 * 4', '16'],
                ['3', '16', 'true', 'i = 16 * 16', '256'],
                ['4', '256', 'true', 'i = 256 * 256', '65536'],
                ['-', '65536', 'false', '迴圈終止', '-']
            ]
        ],
        'conclusion' => '在第 4 次執行 `i = i * i` 後，`i` 的值變為 65536，此時 `65536 < 800` 條件為 false，迴圈結束。因此，迴圈體總共執行了 4 次。 '
    ],
    [
        'question' => '(題號 10) 執行下列程式碼之後，請問最後 s 的值多少？ ',
        'code' => 'int s = 0;
for (int i = 2; i <= 100; i += 2) {
    s += i;
}
printf("s = %d", s);',
        'options' => [
            'A' => '5500',
            'B' => '2550',
            'C' => '5050',
            'D' => '2500'
        ],
        'answer' => 'B',
        'explanation' => '此程式碼計算從 2 到 100 之間所有偶數的總和。這是一個等差數列求和問題。
        <br><b>首項:</b> 2, <b>末項:</b> 100, <b>公差:</b> 2
        <br><b>項數:</b> (100 - 2) / 2 + 1 = 50 項
        <br><b>總和公式:</b> (首項 + 末項) * 項數 / 2',
        'trace' => [
            'headers' => ['計算過程'],
            'rows' => [
                ['(2 + 100) * 50 / 2'],
                ['102 * 50 / 2'],
                ['5100 / 2'],
                ['2550']
            ]
        ],
        'conclusion' => '因此，`s` 的最終值為 2550。 '
    ],
    [
        'question' => '(題號 18) 執行下列 C 程式片段，請問最後輸出是？',
        'code' => '#include <stdio.h>

void main() {
    int number = 1061130, result;
    do {
        result = number % 10;
        printf("%i", result);
        number = number / 10;
    } while (number != 0);
}',
        'options' => [
            'A' => '1061130',
            'B' => '0311601',
            'C' => '106113',
            'D' => '311601'
        ],
        'answer' => 'B',
        'explanation' => '此程式使用 `do-while` 迴圈，透過取餘數 (`% 10`) 和整數除法 (`/ 10`) 的方式，從個位數開始，逐一印出一個整數的每一位，進而實現數字反轉的效果。 ',
        'trace' => [
            'headers' => ['迴圈開始前 number', 'result = number % 10', '輸出', 'number = number / 10', '條件 (number != 0)'],
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
        'conclusion' => '迴圈從 `number` 的個位數開始印，直到 `number` 變為 0。因此，最終螢幕上的輸出組合起來就是 `0311601`。 '
    ],
    [
        'question' => '(題號 27) 執行下列程式碼後，請問輸出結果為？',
        'code' => '#include <stdio.h>

int main() {
    int x = 0, y = 0;
    for (y = 1; y <= 20; y++) {
        int z = y % 5;
        if (z == 0)
            x++;
    }
    printf("%3d%3d", x, y);
    return 0;
}',
        'options' => [
            'A' => '0 0',
            'B' => '4 21',
            'C' => '2 11',
            'D' => '3 11'
        ],
        'answer' => 'B',
        'explanation' => '此程式碼的 `for` 迴圈會執行 20 次 (從 `y=1` 到 `y=20`)。在迴圈中，它會檢查 `y` 是否為 5 的倍數，如果是，則將 `x` 的值加 1。  最後，它會印出 `x` 和 `y` 的值。',
        'trace' => [
            'headers' => ['y 的值', 'z = y % 5', 'if (z == 0)', 'x 的值'],
            'rows' => [
                ['1...4', '1...4', 'false', '0'],
                ['5', '0', 'true', '1'],
                ['6...9', '1...4', 'false', '1'],
                ['10', '0', 'true', '2'],
                ['11...14', '1...4', 'false', '2'],
                ['15', '0', 'true', '3'],
                ['16...19', '1...4', 'false', '3'],
                ['20', '0', 'true', '4']
            ]
        ],
        'conclusion' => '迴圈在 `y` 為 5, 10, 15, 20 時，`x` 會增加，所以迴圈結束後 `x` 的值為 4。`for` 迴圈的終止條件是 `y <= 20`。當 `y` 為 20 時，迴圈體執行完，`y` 再執行 `y++` 變成 21，此時 `21 <= 20` 為 false，迴圈終止。所以最後印出的 `y` 值是 21。最終輸出為 `4 21`。 '
    ],
];

// --- 程式碼開始 ---
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C語言互動選擇題 - 迴圈練習</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>

    <script>
    MathJax = {
      tex: {
        inlineMath: [['$', '$'], ['\\(', '\\)']],
        displayMath: [['$$', '$$'], ['\\[', '\\]']],
        processEscapes: true
      },
      svg: {
        fontCache: 'global'
      }
    };
    </script>
    <script type="text/javascript" id="MathJax-script" async
      src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js">
    </script>

    <style>
        /* --- 整體與佈局 --- */
        :root {
            --background-color: #1e1e1e;
            --text-color: #d4d4d4;
            --primary-color: #007acc;
            --container-bg: #252526;
            --border-color: #3c3c3c;
            --header-bg: #333333;
            --button-bg: #0e639c;
            --button-hover-bg: #007acc;
            --correct-bg: rgba(45, 211, 111, 0.1);
            --correct-border: #2dd36f;
            --incorrect-bg: rgba(235, 68, 90, 0.1);
            --incorrect-border: #eb445a;
            --splitter-color: #505050;
        }

        body {
            font-family: 'Segoe UI', 'Microsoft JhengHei', 'PingFang TC', sans-serif;
            margin: 0;
            background-color: var(--background-color);
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .header {
            background-color: var(--header-bg);
            padding: 10px 20px;
            border-bottom: 2px solid var(--primary-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .header h1 {
            margin: 0;
            font-size: 1.5em;
        }

        .theme-switcher {
            cursor: pointer;
            font-size: 1.5em;
        }

        .container {
            display: flex;
            flex-grow: 1;
            overflow: hidden;
        }

        /* --- 雙欄可拖曳 --- */
        .main-content {
            padding: 20px;
            overflow-y: auto;
            width: 70%;
            flex-shrink: 0;
            box-sizing: border-box;
        }

        .splitter {
            width: 8px;
            background-color: var(--splitter-color);
            cursor: col-resize;
            flex-shrink: 0;
        }

        .ide-container {
            display: flex;
            flex-direction: column;
            width: 30%;
            flex-shrink: 0;
            background-color: var(--container-bg);
            padding: 10px;
            box-sizing: border-box;
        }

        /* --- 測驗內容 --- */
        .quiz-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .question-card {
            background-color: var(--container-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 25px;
            padding: 25px;
            display: none; /* 預設隱藏所有題目 */
        }
        .question-card.active {
            display: block; /* 只顯示當前題目 */
        }

        .question-title {
            font-size: 1.2em;
            margin-bottom: 15px;
            font-weight: 600;
        }

        /* 程式碼區塊 */
        pre[class*="language-"] {
            border-radius: 6px;
            padding: 1.2em !important;
            margin: 20px 0 !important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            border: 1px solid #4a4a4a;
        }

        /* 選項 */
        .options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .option {
            background-color: #333;
            padding: 15px;
            border: 2px solid transparent;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            display: flex;
            align-items: center;
        }

        .option:hover {
            border-color: var(--primary-color);
        }

        .option.selected {
            border-color: #9cdcfe;
            background-color: #3a3d41;
        }

        .option input[type="radio"] {
            display: none;
        }

        .option .option-label {
            font-weight: bold;
            margin-right: 10px;
            color: var(--primary-color);
        }

        /* 詳解區塊 */
        .explanation {
            margin-top: 25px;
            padding: 20px;
            border-radius: 6px;
            display: none; /* 預設隱藏 */
            border-left: 5px solid;
        }
        .explanation.correct {
            background-color: var(--correct-bg);
            border-color: var(--correct-border);
        }
        .explanation.incorrect {
            background-color: var(--incorrect-bg);
            border-color: var(--incorrect-border);
        }

        .explanation-title {
            font-weight: bold;
            font-size: 1.1em;
            margin-bottom: 10px;
        }

        /* 變數追蹤表格 */
        .trace-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 0.9em;
        }
        .trace-table th, .trace-table td {
            border: 1px solid var(--border-color);
            padding: 8px 12px;
            text-align: center;
        }
        .trace-table th {
            background-color: #3e3e42;
            font-weight: 600;
        }
        .trace-table td {
             background-color: #2d2d30;
             font-family: 'Consolas', 'Menlo', 'Monaco', monospace;
        }
        .trace-table tr:nth-child(even) td {
            background-color: #333337;
        }

        .conclusion {
            margin-top: 15px;
            font-style: italic;
        }

        /* 導航按鈕 */
        .navigation {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .nav-button {
            background-color: var(--button-bg);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.2s;
            display: none; /* 預設隱藏 */
        }
        .nav-button:hover {
            background-color: var(--button-hover-bg);
        }
        .nav-button:disabled {
            background-color: #555;
            cursor: not-allowed;
        }

        /* --- IDE/程式碼沙箱 --- */
        #editor {
            height: 60%;
            width: 100%;
            border-radius: 5px;
        }
        #output-container {
            flex-grow: 1;
            margin-top: 10px;
            background: #1a1a1a;
            color: #f1f1f1;
            padding: 10px;
            border-radius: 5px;
            overflow-y: auto;
            font-family: 'Consolas', 'Menlo', 'Monaco', monospace;
            white-space: pre-wrap;
            border: 1px solid var(--border-color);
        }
        .ide-controls {
            margin: 10px 0;
            display: flex;
            gap: 10px;
        }
        .ide-button {
             background-color: #3e8e41;
             color: white;
             padding: 8px 15px;
             border: none;
             border-radius: 4px;
             cursor: pointer;
             transition: background-color 0.2s;
        }
         .ide-button:hover {
             background-color: #4caf50;
         }
    </style>
</head>
<body>

    <header class="header">
        <h1>C語言互動選擇題 - 迴圈</h1>
        <div class="theme-switcher" onclick="toggleTheme()">🌙</div>
    </header>

    <div class="container">
        <div class="main-content">
            <div class="quiz-container">
                <?php foreach ($quizData as $index => $q): ?>
                    <div class="question-card" id="q<?php echo $index; ?>" data-answer="<?php echo $q['answer']; ?>">
                        <div class="question-title">
                            <?php echo ($index + 1) . '. ' . $q['question']; ?>
                        </div>

                        <?php if (!empty($q['code'])): ?>
                            <pre><code class="language-c"><?php echo htmlspecialchars($q['code']); ?></code></pre>
                        <?php endif; ?>

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
                                        <tr>
                                            <?php foreach ($q['trace']['headers'] as $header): ?>
                                                <th><?php echo $header; ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($q['trace']['rows'] as $row): ?>
                                            <tr>
                                                <?php foreach ($row as $cell): ?>
                                                    <td><?php echo $cell; ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>

                            <?php if (isset($q['conclusion'])): ?>
                                <p class="conclusion"><?php echo $q['conclusion']; ?></p>
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
        // --- ACE Editor and WASM/Emscripten Setup ---
        let editor = ace.edit("editor");
        editor.setTheme("ace/theme/tomorrow_night");
        editor.session.setMode("ace/mode/c_cpp");

        const outputContainer = document.getElementById('output-container');

        // This is a placeholder for the Emscripten `ccall` function
        // In a real implementation, you would load a WASM module compiled from C
        // For demonstration, we'll simulate a simple "run" function
        function runCode(code) {
             // A real implementation would post the code to a backend or use client-side WASM
             return new Promise((resolve) => {
                outputContainer.textContent = "正在編譯與執行...\n";
                setTimeout(() => {
                    // Simple simulation
                    if (code.includes('printf("Hello, World!\\n");')) {
                        resolve("Hello, World!\n");
                    } else if (code.includes('x += n;')) {
                         resolve("模擬輸出:\nx = 45\n");
                    } else {
                        resolve("模擬執行完成。\n(此為展示用沙箱，不具備完整編譯功能)");
                    }
                }, 1000);
             });
        }

        document.getElementById('run-btn').addEventListener('click', async () => {
            const code = editor.getValue();
            const result = await runCode(code);
            outputContainer.textContent += result;
        });

        document.getElementById('clear-output-btn').addEventListener('click', () => {
            outputContainer.textContent = "輸出結果將顯示在這裡...";
        });

        // --- Quiz Logic ---
        const questions = document.querySelectorAll('.question-card');
        const nextBtn = document.getElementById('next-btn');
        let currentQuestionIndex = 0;
        const totalQuestions = <?php echo count($quizData); ?>;

        function showQuestion(index) {
            questions.forEach((q, i) => {
                q.classList.toggle('active', i === index);
            });
            nextBtn.style.display = 'none';
            if (index >= totalQuestions - 1) {
                nextBtn.textContent = '完成測驗';
            } else {
                 nextBtn.textContent = '下一題';
            }
        }

        questions.forEach((card, index) => {
            const options = card.querySelectorAll('.option');
            const explanation = card.querySelector('.explanation');

            options.forEach(option => {
                option.addEventListener('click', () => {
                    // Prevent changing answer
                    if (card.dataset.answered) return;
                    card.dataset.answered = 'true';

                    // Deselect others
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
                // Optionally, reset or show results summary
                currentQuestionIndex = 0;
                // You might want to reset all questions here if you allow retakes
                window.location.reload();
            }
        });

        // Initialize first question
        showQuestion(0);

        // --- Layout Splitter Logic ---
        const splitter = document.getElementById('splitter');
        const mainContent = document.querySelector('.main-content');
        const ideContainer = document.querySelector('.ide-container');

        let isDragging = false;
        splitter.addEventListener('mousedown', (e) => {
            e.preventDefault();
            isDragging = true;
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
                 ideContainer.style.width = `${100 - newLeftPercent}%`;
            }
        }

        function onMouseUp() {
            isDragging = false;
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
        }

        // --- Theme Switcher ---
        function toggleTheme() {
            // This is a simplified theme switcher. A real one would toggle a class on the body
            // and have CSS variables for both light and dark themes.
            alert("主題切換功能待實現！");
        }

    </script>
</body>
</html>
