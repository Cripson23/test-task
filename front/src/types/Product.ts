export interface Product {
    id: number;
    title: string;
    subtitle: string;
    description: string;
    price: number;
    image_path: string;
    isOrdering: boolean;
    isOrdered: boolean;
    isSale: boolean;
    isSoldOut: boolean;
}