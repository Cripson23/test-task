/**
 * Генерация случайного числа с учетом исключений
 * @param excludes
 * @param max
 */
export function getRandomExclude(excludes: number[], max: number) {
    excludes = excludes.filter(e => e < max).sort((a, b) => a - b);  // Фильтруем и сортируем исключения
    let result = Math.floor(Math.random() * (max - excludes.length));  // Уменьшаем диапазон на количество исключений
    for (let exclude of excludes) {
        if (result >= exclude) result++;  // Сдвигаем результат, если он попадает в зону исключения
    }
    return result;
}