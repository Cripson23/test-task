import { Product } from "../types/Product";
import { getRandom, getRandomExclude } from "../helpers/getRandom";

/**
 * Описание товара по умолчанию
 * @param data
 */
export function initializeProduct(data: any): Product {
    return {
        id: data.id,
        title: data.title,
        subtitle: data.subtitle,
        description: data.description,
        price: data.price,
        image_path: data.image_path,
        isOrdering: false,
        isOrdered: false,
        isSale: false,
        isSoldOut: false
    };
}

/**
 * Определение случайного товара по скидке и распроданного товара
 * @param products
 */
export function assignRandomFlags(products: Product[]): Product[] {
    const newProducts = [...products];
    const isSaleRandomIndex = getRandom(0, newProducts.length);
    newProducts[isSaleRandomIndex].isSale = true;

    if (newProducts.length > 1) {
        const isSoldOutRandomIndex = getRandomExclude([isSaleRandomIndex], 0, newProducts.length);
        newProducts[isSoldOutRandomIndex].isSoldOut = true;
        console.log(isSoldOutRandomIndex);
    }

    return newProducts;
}