<?php
/**
 * Вспомогательная функция для добавления пробелов
 * 
 * @param int $count Количество проболов.
 * @return string
 */
function getSpace(int $count): string
{
    $str = '';
    $i = 0;
    while ($i <= $count) {
        $str .= '&nbsp;&nbsp;&nbsp;&nbsp;';
        $i++;
    }
    return $str;
}

/**
 * Выполняет рекурсивный обход дерева каталога
 *
 * @param string $directoryPath Начальный путь
 * @param int $level Уровень вложенности
 */
function scan_directory(string $directoryPath, int $level = 0): void
{
    $directoryPath = realpath($directoryPath);
    $dataInDirectory = scandir($directoryPath);

    if (!$dataInDirectory) {
        return;
    }

    foreach ($dataInDirectory as $fileName) {
        if ($fileName == '.' || $fileName == '..') {
            continue;
        }

        if (is_dir($directoryPath . DIRECTORY_SEPARATOR . $fileName)) {
            echo "<br>" . getSpace($level) . $fileName . ">>>";
            scan_directory($directoryPath . DIRECTORY_SEPARATOR . $fileName, $level + 1);
            continue;
        }

        echo "<br>" . getSpace($level) . $fileName;
    }
}

scan_directory(__DIR__);
