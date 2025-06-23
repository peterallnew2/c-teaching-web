// script.js
document.addEventListener('DOMContentLoaded', function () {
    // 代碼範例
    const codeSamples = {
        'var-declare': `#include <stdio.h>\n\nint main() {\n    int age = 25;\n    char grade = 'A';\n\n    printf("年齡: %d\\n", age);\n    printf("等級: %c\\n", grade);\n\n    return 0;\n}`,
        'multi-declare': `#include <stdio.h>\n\nint main() {\n    double price = 99.9, weight = 5.2, tax = 0.05;\n\n    printf("價格: %.2f\\n", price);\n    printf("重量: %.1f\\n", weight);\n    printf("稅率: %.2f\\n", tax);\n\n    return 0;\n}`,
        'sizeof-op': `#include <stdio.h>\n\nint main() {\n    printf("int 的大小: %zu bytes\\n", sizeof(int));\n    printf("double 的大小: %zu bytes\\n", sizeof(double));\n    printf("char 的大小: %zu bytes\\n", sizeof(char));\n\n    return 0;\n}`,
        'const-keyword': `#include <stdio.h>\n\nint main() {\n    const int MAX_ATTEMPTS = 3;\n    printf("最大嘗試次數為: %d\\n", MAX_ATTEMPTS);\n    return 0;\n}`,
        'define-directive': `#include <stdio.h>\n\n#define PI 3.14159\n\nint main() {\n    double radius = 10.0;\n    double area = PI * radius * radius;\n    printf("半徑為 %.1f 的圓面積為: %f\\n", radius, area);\n    return 0;\n}`,
        'enum-type': `#include <stdio.h>\n\nenum Action { UP, DOWN, LEFT, RIGHT, STOP };\n\nint main() {\n    enum Action act = UP;\n    printf("act 的值是 (UP): %d\\n", act);\n    act = STOP;\n    printf("act 的值是 (STOP): %d\\n", act);\n    return 0;\n}`
    };

    const codeEditor = document.getElementById('code-editor');
    const outputArea = document.getElementById('output-area');
    const runCodeBtn = document.getElementById('run-code-btn');

    // 運行範例按鈕點擊事件
    document.querySelectorAll('.run-example-btn').forEach(button => {
        button.addEventListener('click', () => {
            const codeId = button.getAttribute('data-code-id');
            if (codeSamples[codeId]) {
                codeEditor.value = codeSamples[codeId];
                outputArea.textContent = '程式碼已載入。點擊「編譯與執行」查看結果。';
                document.querySelector('.interactive-panel').scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // 編譯與執行按鈕點擊事件
    runCodeBtn.addEventListener('click', async () => {
        outputArea.textContent = '編譯中，請稍候...';
        runCodeBtn.disabled = true;

        const oldIframe = document.getElementById('emcc-sandbox');
        if (oldIframe) {
            oldIframe.remove();
        }

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
            if (!js || !wasm) {
                throw new Error('後端回應格式不正確，未包含 JS 或 WASM 資料。');
            }

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

                iframeWindow.parentPrint = (text) => {
                    outputArea.textContent += text + '\n';
                };
                iframeWindow.parentPrintError = (text) => {
                    outputArea.textContent += `[錯誤]: ${text}\n`;
                };
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
                        onRuntimeInitialized: () => {
                            setTimeout(() => window.parentSignalEnd(), 50);
                        }
                    };

                    const scriptElement = document.createElement('script');
                    scriptElement.textContent = window.EMCC_JS_CODE;
                    document.body.appendChild(scriptElement);
                `;
                iframe.contentDocument.body.appendChild(bootstrapScript);
            };

            document.body.appendChild(iframe);

        } catch (e) {
            outputArea.textContent = '請求或執行時發生錯誤：\n\n' + e.message + '\n\n請確認您的後端編譯服務 (http://c.ksvs.kh.edu.tw:3000/compile) 已正確啟動。';
            runCodeBtn.disabled = false;
        }
    });

    // 測驗邏輯
    document.querySelectorAll('.quiz-options').forEach(optionsContainer => {
        optionsContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('option') && !this.classList.contains('answered')) {
                const selectedOption = e.target;
                const correctAnswer = this.getAttribute('data-correct');
                const selectedAnswer = selectedOption.getAttribute('data-option');

                this.classList.add('answered');

                const options = this.querySelectorAll('.option');
                options.forEach(opt => {
                    const optValue = opt.getAttribute('data-option');
                    let marker = '';
                    if (optValue === correctAnswer) {
                        opt.classList.add('correct');
                        marker = ' ✅';
                    } else if (optValue === selectedAnswer) {
                        opt.classList.add('incorrect');
                        marker = ' ❌';
                    }
                    opt.innerHTML += marker;
                    opt.classList.add('answered');
                });

                const explanation = this.nextElementSibling;
                if (explanation && explanation.classList.contains('explanation')) {
                    explanation.style.display = 'block';
                }
            }
        });
    });

    // 下一題按鈕邏輯
    document.querySelectorAll('.next-btn').forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // 左右拉動調整寬度邏輯
    const resizer = document.getElementById('dragMe');
    const leftSide = document.querySelector('.tutorial-content');
    const rightSide = document.querySelector('.interactive-panel');

    const mouseDownHandler = function (e) {
        let x = e.clientX;
        let leftWidth = leftSide.getBoundingClientRect().width;

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

        function mouseMoveHandler(e) {
            const dx = e.clientX - x;
            const newLeftWidth = leftWidth + dx;

            leftSide.style.width = `${newLeftWidth}px`;
        }

        function mouseUpHandler() {
            document.body.removeChild(overlay);
            document.removeEventListener('mousemove', mouseMoveHandler);
            document.removeEventListener('mouseup', mouseUpHandler);
        }
    };

    resizer.addEventListener('mousedown', mouseDownHandler);

    // 設置編輯器初始代碼
    if (codeEditor) {
        codeEditor.value = codeSamples['var-declare'];
    }
});
