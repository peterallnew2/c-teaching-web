// script3.js - 包含從 2.txt 提取的第二章C語言程式碼範例
// 假設 script2.js 已先加載並定義了全局的 codeSamples 對象
// 或者，如果 codeSamples 不是全局的，则需要调整 7-split.php 中的代码加载逻辑
// 为了安全和符合“script2.js不变”的原则，这里会尝试添加到全局的 codeSamples
// 如果全局的 codeSamples 是用 const 声明的，这种方式在严格模式下或某些实现中可能不理想，
// 但这是在不修改 script2.js 的前提下最直接的方式。

if (typeof codeSamples === 'undefined') {
    // 如果 script2.js 由于某种原因没有定义 codeSamples，或者 script3.js 先加载了
    // 我们在这里定义它，以避免错误。但这可能与 script2.js 中的 const 声明冲突。
    // 一个更好的方式是让 script2.js 保证 codeSamples 是一个全局可修改的对象 (e.g., using var or let at top level, or window.codeSamples)
    // 或者，页面中处理代码的函数应该能从多个源获取代码。
    // 为简单起见，这里假设如果 script2.js 的 const codeSamples 存在，我们可以添加属性。
    console.warn("script2.js 中的 'codeSamples' 未找到或未先加载，script3.js 将尝试自行创建或扩展。");
    // 如果是 const codeSamples = {} 在 script2.js, 直接赋值会失败。
    // 但向对象添加属性通常是允许的。
}

// 确保 codeSamples 是一个对象
var codeSamples = (typeof codeSamples !== 'undefined' && codeSamples !== null && typeof codeSamples === 'object') ? codeSamples : {};

codeSamples['ch2_hello_world'] = `#include <stdio.h>

// 這是一個簡單的C程式
int main() {
    printf("Hello, World!\\n"); // \\n 是換行符
    return 0; // main函式回傳0表示程式正常結束
}`;

codeSamples['ch2_variable_declaration'] = `#include <stdio.h>

int main() {
    int score = 100;       // 宣告整數變數 score 並賦值100
    char level = 'A';      // 宣告字元變數 level 並賦值 'A'
    float temperature = 25.5f; // 宣告浮點數變數 temperature

    printf("分數: %d\\n", score);
    printf("等級: %c\\n", level);
    printf("溫度: %.1f 度C\\n", temperature); // %.1f 表示輸出到小數點後一位

    return 0;
}`;

codeSamples['ch2_sizeof_operator'] = `#include <stdio.h>

int main() {
    // sizeof 是一個運算子，用來取得資料型態或變數所佔用的記憶體大小 (單位為 byte)
    printf("int 型態的大小: %zu bytes\\n", sizeof(int));
    printf("char 型態的大小: %zu bytes\\n", sizeof(char));
    printf("float 型態的大小: %zu bytes\\n", sizeof(float));
    printf("double 型態的大小: %zu bytes\\n", sizeof(double));

    int my_array[10];
    printf("包含10個int的陣列大小: %zu bytes\\n", sizeof(my_array));

    return 0;
}`;
// %zu 是 C99 標準中用於 sizeof 回傳值 size_t 型態的格式指定字元

codeSamples['ch2_const_variable'] = `#include <stdio.h>

// 使用 const 關鍵字宣告常數
const double PI = 3.1415926535;
const int MAX_VALUE = 100;

int main() {
    printf("PI 的值: %f\\n", PI);
    printf("MAX_VALUE 的值: %d\\n", MAX_VALUE);

    // 下一行如果取消註解會導致編譯錯誤，因為常數的值不能被修改
    // PI = 3.14;
    // MAX_VALUE = 200;

    double radius = 5.0;
    double area = PI * radius * radius;
    printf("半徑為 %.1f 的圓面積: %f\\n", radius, area);

    return 0;
}`;

codeSamples['ch2_define_constant'] = `#include <stdio.h>

// 使用 #define 前置處理指令定義符號常數 (巨集)
// #define 會在編譯前進行簡單的文本替換
#define GREETING "Hello, C Learner!"
#define MAX_ITEMS 10
#define VERSION "1.0.2"

int main() {
    printf("%s\\n", GREETING);
    printf("最大項目數: %d\\n", MAX_ITEMS);
    printf("目前版本: %s\\n", VERSION);

    // 注意：#define 定義的常數沒有型態，且通常不以分號結尾
    // int num_items = MAX_ITEMS; // 合法
    return 0;
}`;

codeSamples['ch2_enum_example'] = `#include <stdio.h>

// 使用 enum (列舉) 定義一組相關的整數常數
// 若未指定值，第一個成員預設為0，後續成員依次遞增1
enum Day { SUNDAY, MONDAY, TUESDAY, WEDNESDAY, THURSDAY, FRIDAY, SATURDAY };
// SUNDAY = 0, MONDAY = 1, ..., SATURDAY = 6

// 也可以自訂起始值或特定成員的值
enum Status { OK = 0, ERROR = -1, PENDING = 100, COMPLETE }; // COMPLETE 會是 101

int main() {
    enum Day today = WEDNESDAY;
    enum Status current_status = PENDING;

    printf("今天是星期 (0-6): %d\\n", today); // 輸出 3

    if (today == WEDNESDAY) {
        printf("今天是星期三！\\n");
    }

    printf("目前狀態 (PENDING): %d\\n", current_status); // 輸出 100
    current_status = COMPLETE;
    printf("更新後狀態 (COMPLETE): %d\\n", current_status); // 輸出 101

    return 0;
}`;

codeSamples['ch2_printf_examples'] = `#include <stdio.h>

int main() {
    int integer_val = 75;
    float float_val = 3.14159f;
    char char_val = 'Z';
    char string_val[] = "C 語言世界"; // C 字串是字元陣列

    printf("--- 整數輸出 ---\\n");
    printf("十進位: %d\\n", integer_val);
    printf("八進位: %o\\n", integer_val);   // 輸出 113 (八進位)
    printf("十六進位 (小寫): %x\\n", integer_val); // 輸出 4b (十六進位)
    printf("十六進位 (大寫): %X\\n", integer_val); // 輸出 4B (十六進位)
    printf("欄寬為5，靠右對齊: [%5d]\\n", integer_val);
    printf("欄寬為5，不足補零，靠右: [%05d]\\n", integer_val);
    printf("欄寬為5，靠左對齊: [%-5d]\\n", integer_val);

    printf("\\n--- 浮點數輸出 ---\\n");
    printf("預設 (6位小數): %f\\n", float_val);
    printf("指定2位小數: %.2f\\n", float_val);
    printf("科學記號 (小寫e): %e\\n", float_val);
    printf("科學記號 (大寫E): %E\\n", float_val);
    printf("欄寬10，2位小數: [%10.2f]\\n", float_val);

    printf("\\n--- 字元與字串輸出 ---\\n");
    printf("字元: %c (ASCII: %d)\\n", char_val, char_val);
    printf("字串: %s\\n", string_val);

    printf("\\n--- 特殊輸出 ---\\n");
    printf("百分比符號: %%\\n"); // 輸出一個 %

    return 0;
}`;

codeSamples['ch2_scanf_example'] = `#include <stdio.h>

int main() {
    int age;
    float height;
    char initial;
    char full_name[50]; // 足夠大的緩衝區來存放名字和結尾的 null 字元

    printf("請輸入您的姓氏第一個字母: ");
    scanf(" %c", &initial); // %c 前的空格可以幫助消耗掉之前輸入可能留下的換行符

    // 清除輸入緩衝區中可能剩餘的字元，直到換行符
    while(getchar() != '\\n');

    printf("請輸入您的全名 (例如 Peter Wang): ");
    // scanf("%s", full_name); // 這樣只會讀到第一個空格
    // 使用 fgets 更安全地讀取包含空格的整行
    fgets(full_name, sizeof(full_name), stdin);
    // fgets 可能會讀取換行符，如果需要可以移除它
    // (簡單移除法，可能不完美)
    for (int i = 0; full_name[i] != '\\0'; i++) {
        if (full_name[i] == '\\n') {
            full_name[i] = '\\0';
            break;
        }
    }

    printf("請輸入您的年齡: ");
    scanf("%d", &age);

    printf("請輸入您的身高 (公尺，例如 1.75): ");
    scanf("%f", &height);

    printf("\\n--- 您輸入的資料 ---\\n");
    printf("姓氏首字母: %c\\n", initial);
    printf("全名: %s\\n", full_name);
    printf("年齡: %d 歲\\n", age);
    printf("身高: %.2f 公尺\\n", height);

    return 0;
}`;

// 如果7-split.php中的按鈕也使用了script2.js中定义的codeSamples键，
// 我们需要将这些键也加入，或者确保7-split.php的JS逻辑能处理多个代码对象。
// 为了简单起见，并假设script2.js中的codeSamples也是全局可访问的，
// 我们这里可以合并，但要注意键名冲突。
// 如果script2.js的codeSamples是const，则不能重新声明。
// 假设这是唯一为codeSamples提供数据的地方，或者script2.js的codeSamples是空的或用于不同章节。

// console.log("script3.js loaded and ch2_codeCollection populated.");
// console.log(codeSamples); // 检查合并后的结果
