export interface Product {
    id: number;
    title: string;
    subtitle: string;
    description: string;
    price: number;
    image_path: string;
    isSale?: boolean;
    isSoldOut?: boolean;
}