/**
 * Генерация случайного числа от min до max.
 * @param min Начальное значение диапазона (включительно).
 * @param max Конечное значение диапазона (исключительно).
 */
export function getRandom(min: number, max: number) {
    return Math.floor(Math.random() * (max - min)) + min;
}

/**
 * Генерация случайного числа от min до max с учетом исключений.
 * @param excludes Массив чисел, которые должны быть исключены из результата.
 * @param min Начальное значение диапазона (включительно).
 * @param max Конечное значение диапазона (исключительно).
 */
export function getRandomExclude(excludes: number[], min: number, max: number) {
    excludes = excludes.filter(e => e >= min && e < max).sort((a, b) => a - b);  // Фильтруем исключения в пределах диапазона и сортируем
    let range = max - min;  // Полный диапазон
    let adjustedMax = range - excludes.length;  // Уменьшаем диапазон на количество исключений
    let result = Math.floor(Math.random() * adjustedMax) + min;
    for (let exclude of excludes) {
        if (result >= exclude) result++;  // Сдвигаем результат, если он попадает в зону исключения
    }
    return result;
}