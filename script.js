document.addEventListener('DOMContentLoaded', function() {
    // This is a global or page-specific object.
    // For a multi-page setup like this, `window.pageCodeSamples` will be populated by
    // a script tag in each specific PHP page (e.g., main_interactive_page.php, ee7-1.php)
    // with its own set of code samples.
    // The `codeSamples` variable below acts as a fallback if `window.pageCodeSamples` isn't defined.
    const fallbackCodeSamples = {
        'q1-code': '#include <stdio.h>\nint TestYou(int a, int b){ if (b==0) return 1; if (b==1) return a; else return (a*TestYou(a, b-1)); }\nint main(void){ int c=TestYou(2,7); printf("%d\\n", c); return 0; }',
        // ... other cc6-3.php specific samples ...
        'q19-code': '#include <stdio.h>\n#define N_Q45 11\nvoid swap_q45_pass_by_value(int a, int b){ int tmp; tmp=a; a=b; b=tmp;}\nvoid swap_q45_working(int *a, int *b){int tmp = *a; *a = *b; *b = tmp;}\nint main(void){\n    int numbers[N_Q45]={1,3,5,7,9,2,4,6,8,0,\'a\'};\n    int tmp, i, min_idx;\n    printf("Original: "); for(i=0; i<N_Q45; i++) printf("%d ", numbers[i]); printf("\\n");\n    for(min_idx=0; min_idx<N_Q45; min_idx++) {\n        for(i=0; i<N_Q45; i++){\n            if(numbers[i]<numbers[min_idx]){\n                tmp=numbers[min_idx];\n                numbers[min_idx]=numbers[i];\n                numbers[i]=tmp;\n            }\n        }\n    }\n    printf("Sorted (as per question logic): ");\n    for(i=0; i<N_Q45; i++){ printf("%d ", numbers[i]); }\n    printf("\\n");\n    return 0;\n}'
    };

    const codeEditor = document.getElementById('code-editor');
    const outputArea = document.getElementById('output-area');
    const runCodeBtn = document.getElementById('run-code-btn');

    function getActiveCodeSamples() {
        return window.pageCodeSamples || fallbackCodeSamples;
    }

    function loadCodeSample(event) {
        const button = event.currentTarget;
        const codeId = button.getAttribute('data-code-id');
        const activeSamples = getActiveCodeSamples();

        if (activeSamples[codeId]) {
            codeEditor.value = activeSamples[codeId];
            outputArea.textContent = '程式碼已載入。點擊「編譯與執行」來查看結果。';
            const panel = document.querySelector('.interactive-panel');
            if (panel) {
                panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        } else {
            console.warn("Code sample not found for ID:", codeId, "in active set:", activeSamples);
            outputArea.textContent = '找不到此範例的程式碼。';
        }
    }

    document.querySelectorAll('.run-example-btn').forEach(button => {
        button.addEventListener('click', loadCodeSample);
    });

    if (runCodeBtn) {
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
                            onExit: (status) => { window.parentSignalEnd(); }
                        };
                        const scriptElement = document.createElement('script');
                        scriptElement.textContent = window.EMCC_JS_CODE;
                        document.body.appendChild(scriptElement);
                    `;
                    iframe.contentDocument.body.appendChild(bootstrapScript);
                };
                document.body.appendChild(iframe);
            } catch (e) {
                outputArea.textContent = '請求或執行時發生錯誤：\n\n' + e.message + '\n\n請確認您的本機後端編譯服務 (例如 http://c.ksvs.kh.edu.tw:3000/compile) 已正確啟動。';
                runCodeBtn.disabled = false;
            }
        });
    }

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
    if (resizer && leftSide) {
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
                const minLeftWidth = parseInt(getComputedStyle(leftSide).minWidth, 10) || 200;
                const minRightWidth = 250;
                if (newLeftWidth > minLeftWidth && newLeftWidth < (document.body.clientWidth - minRightWidth)) {
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
    }

    // Initial code load for the editor
    if (codeEditor) {
        const activeSamples = getActiveCodeSamples();
        const editorInitialValue = codeEditor.value.trim();
        if (editorInitialValue === "" || editorInitialValue.startsWith("/* Default code") || editorInitialValue.startsWith("// Welcome!")) {
            if (Object.keys(activeSamples).length > 0) {
                const firstCodeId = Object.keys(activeSamples)[0];
                if (activeSamples[firstCodeId]) {
                    codeEditor.value = activeSamples[firstCodeId];
                }
            } else {
                 codeEditor.value = "// Welcome! No runnable examples currently loaded for this page.";
            }
        }
    }
});
