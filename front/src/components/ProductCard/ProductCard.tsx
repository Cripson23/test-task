import React from 'react';
import { Product } from "../../types/Product";
import { Card, ProductImage, ProductTitle, ProductDescription, OrderButton } from "./ProductCard.styles";

interface ProductCardProps {
    product: Product;
    onOrder: (id: number) => void;
}

const ProductCard: React.FC<ProductCardProps> = ({ product, onOrder }) => {
    return (
        <Card>
            <ProductImage src={process.env.REACT_APP_API_ENDPOINT + product.image_path} alt={product.title} />
            <ProductTitle>{product.title}</ProductTitle>
            <ProductDescription>{product.description}</ProductDescription>
            <OrderButton onClick={() => onOrder(product.id)}>Заказать</OrderButton>
        </Card>
    );
};

export default ProductCard;