const codeSamples = {
    'var-declare': `#include <stdio.h>\n\nint main() {\n    int age = 25;\n    char grade = 'A';\n\n    printf("年齡: %d\\n", age);\n    printf("等級: %c\\n", grade);\n\n    return 0;\n}`,
    'multi-declare': `#include <stdio.h>\n\nint main() {\n    double price = 99.9, weight = 5.2, tax = 0.05;\n\n    printf("價格: %.2f\\n", price);\n    printf("重量: %.1f\\n", weight);\n    printf("稅率: %.2f\\n", tax);\n\n    return 0;\n}`,
    'sizeof-op': `#include <stdio.h>\n\nint main() {\n    printf("int 的大小: %zu bytes\\n", sizeof(int));\n    printf("double 的大小: %zu bytes\\n", sizeof(double));\n    printf("char 的大小: %zu bytes\\n", sizeof(char));\n\n    return 0;\n}`,
    'const-keyword': `#include <stdio.h>\n\nint main() {\n    const int MAX_ATTEMPTS = 3;\n    printf("最大嘗試次數為: %d\\n", MAX_ATTEMPTS);\n    return 0;\n}`,
    'define-directive': `#include <stdio.h>\n\n#define PI 3.14159\n\nint main() {\n    double radius = 10.0;\n    double area = PI * radius * radius;\n    printf("半徑為 %.1f 的圓面積為: %f\\n", radius, area);\n    return 0;\n}`,
    'enum-type': `#include <stdio.h>\n\nenum Action { UP, DOWN, LEFT, RIGHT, STOP };\n\nint main() {\n    enum Action act = UP;\n    printf("act 的值是 (UP): %d\\n", act);\n    act = STOP;\n    printf("act 的值是 (STOP): %d\\n", act);\n    return 0;\n}`
};
