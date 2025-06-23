<?php
header('Content-Type: text/html; charset=utf-8');

// PHP logic for ee7-1.php - specific quiz page

$page_title_prefix = "C++ 物件導向";
$html_title = $page_title_prefix . " - 試題練習 (EE7-1)";

// The $current_exercises array will be defined directly in this file later (Step 2 of plan)
// For now, initialize as empty to prevent errors if accessed before definition.
$current_exercises = [];

// No need for external exercises_data.php or get_exercises_for_chapter for this specific page.
// No need for $chapters array or $_GET['chapter'] logic for this specific page.

?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($html_title); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
    <!-- Prism JS for syntax highlighting - core and autoloader are loaded at the end of the body -->
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
    <nav class="main-nav">
        <ul>
            <?php
                $chapter_nav_titles = [
                    'chapter_home' => '課程總覽',
                    'chapter2' => 'CH2 C入門',
                    'chapter3' => 'CH3 資料型態',
                    'chapter4' => 'CH4 運算子',
                    'chapter5' => 'CH5 輸入輸出',
                    'chapter6' => 'CH6 選擇結構',
                    'chapter_cc6_3_practice' => 'CH6-3 練習',
                    'chapter7' => 'CH7 重複結構'
                ];
                foreach ($chapters as $key => $chapter_data):
                    $display_title = $chapter_nav_titles[$key] ?? $chapter_data['title'];
            ?>
                <li><a href="?chapter=<?php echo urlencode($key); ?>" class="<?php echo ($key === $current_chapter_key) ? 'active' : ''; ?>">
                    <?php echo htmlspecialchars($display_title); ?>
                </a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <div class="container">
        <main class="tutorial-content">
            <h1><?php echo htmlspecialchars($current_chapter['title']); ?></h1>

            <?php
            if ($current_chapter_key === 'chapter_home') {
                echo "<h2>歡迎來到C語言互動學習網！</h2>";
                echo "<p>請從上方導覽列選擇一個章節開始學習。每個章節包含教學內容和互動練習題，幫助您鞏固所學知識。</p>";
                echo "<h3>章節列表：</h3><ul>";
                foreach ($chapters as $key => $chapter_data) {
                    if ($key !== 'chapter_home') { // Don't list home as a chapter here
                         echo "<li><a href='?chapter=" . urlencode($key) . "'>" . htmlspecialchars($chapter_data['title']) . "</a></li>";
                    }
                }
                echo "</ul>";
            } elseif (isset($current_chapter['content_file']) && file_exists($current_chapter['content_file'])) {
                include $current_chapter['content_file'];
            } else {
                 echo "<p>教學內容檔案 '" . htmlspecialchars($current_chapter['content_file'] ?? 'N/A') . "' 未找到或未定義。請確認檔案路徑是否正確。</p>";
            }
            ?>

            <div class="quiz-section" id="quiz-section-dynamic">
                <?php if ($current_chapter_key !== 'chapter_home' && $current_chapter_key !== 'chapter_cc6_3_practice' && isset($chapters[$current_chapter_key]['content_file'])): ?>
                    <h2>本章練習</h2>
                    <?php if (!empty($current_exercises)): ?>
                        <p>請挑戰下面的題目，檢驗您的學習成果！</p>
                        <?php foreach ($current_exercises as $index => $exercise): ?>
                            <div id="q<?php echo htmlspecialchars($exercise['id_suffix']); ?>" class="quiz-card">
                                <h3><?php echo htmlspecialchars($index + 1); ?>. <?php echo htmlspecialchars($exercise['question_text']); ?></h3>
                                <?php if (!empty($exercise['code_snippet'])): ?>
                                    <pre><code class="language-c"><?php echo htmlspecialchars($exercise['code_snippet']); ?></code></pre>
                                    <?php if (!empty($exercise['run_code_id'])): // Only show button if run_code_id is present ?>
                                        <button class="run-example-btn" data-code-id="<?php echo htmlspecialchars($exercise['run_code_id']); ?>">運行示例</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <div class="quiz-options" data-correct="<?php echo htmlspecialchars($exercise['correct_answer']); ?>">
                                    <?php foreach ($exercise['options'] as $key => $text): ?>
                                        <div class="option" data-option="<?php echo htmlspecialchars($key); ?>">(<?php echo htmlspecialchars($key); ?>) <?php echo htmlspecialchars($text); ?></div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="explanation">
                                    <?php echo $exercise['explanation_html']; // Raw HTML for explanation ?>
                                </div>
                                <div class="next-btn-container">
                                    <?php if (isset($current_exercises[$index + 1])): ?>
                                        <button class="next-btn" data-target="#q<?php echo htmlspecialchars($current_exercises[$index + 1]['id_suffix']); ?>">下一題</button>
                                    <?php else: ?>
                                        <button class="next-btn" data-target="#q<?php echo htmlspecialchars($current_exercises[0]['id_suffix']); ?>">回到本章第一題</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                         <script>
                            // This script block will populate the pageCodeSamples for the current dynamic exercises
                            // It should be generated by PHP based on $current_exercises
                            window.pageCodeSamples = window.pageCodeSamples || {};
                            <?php foreach ($current_exercises as $exercise): ?>
                                <?php if (!empty($exercise['run_code_id']) && !empty($exercise['code_snippet_for_runner'])): ?>
                                    window.pageCodeSamples['<?php echo htmlspecialchars($exercise['run_code_id']); ?>'] = <?php echo json_encode($exercise['code_snippet_for_runner']); ?>;
                                <?php elseif (!empty($exercise['run_code_id']) && !empty($exercise['code_snippet'])): // Fallback to code_snippet if _for_runner is not defined ?>
                                    window.pageCodeSamples['<?php echo htmlspecialchars($exercise['run_code_id']); ?>'] = <?php echo json_encode($exercise['code_snippet']); ?>;
                                <?php endif; ?>
                            <?php endforeach; ?>
                            // If script.js is loaded after this, it can use window.pageCodeSamples
                            // If script.js is already loaded, we might need to re-initialize its part that uses codeSamples
                            if (typeof initializeCodeSamples === 'function') {
                                initializeCodeSamples(window.pageCodeSamples);
                            }
                        </script>
                    <?php else: ?>
                        <p>本章節目前沒有練習題。</p>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- If $current_chapter_key is 'chapter_cc6_3_practice', its content_file (cc6-3_quiz_content_static.html) is already included above -->
                <!-- That file should contain the quiz cards for that specific section -->
            </div>
        </main>

        <div class="resizer" id="dragMe"></div>

        <aside class="interactive-panel">
            <div class="interactive-panel-inner">
                <div class="sandbox-container">
                    <h3>C 語言程式碼沙箱 (WASM)</h3>
                    <textarea id="code-editor" spellcheck="false">/* 點擊「運行示例」或在此處編寫您的C語言代碼 */</textarea>
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
</body>
</html>
