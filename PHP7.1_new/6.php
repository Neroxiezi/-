<?php
try {
    // Some code...
} catch (ExceptionType1 $e) {
    // 处理 ExceptionType1
} catch (ExceptionType2 $e) {
    // 处理 ExceptionType2
} catch (\Exception $e) {
    // ...
}

try {
    // Some code...
} catch (ExceptionType1 | ExceptionType2 $e) {
    // 对于 ExceptionType1 和 ExceptionType2 的处理
} catch (\Exception $e) {
    // ...
}