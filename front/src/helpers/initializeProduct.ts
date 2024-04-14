import { Product } from "../types/Product";

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