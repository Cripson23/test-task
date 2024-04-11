import React from 'react';
import styled from 'styled-components';
import { Product } from "../types/Product";

interface ProductCardProps {
    product: Product;
    onOrder: (id: number) => void;
}

const Card = styled.div`
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    margin: 10px;
    width: 300px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #fff;
`;

const ProductImage = styled.img`
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
`;

const ProductTitle = styled.h2`
    color: #333;
    font-size: 18px;
    margin: 10px 0;
`;

const ProductDescription = styled.p`
    color: #666;
    font-size: 14px;
    text-align: center;
`;

const OrderButton = styled.button`
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    margin-top: 15px;
    transition: background-color 0.2s;

    &:hover {
        background-color: #0056b3;
    }
`;

const ProductCard: React.FC<ProductCardProps> = ({ product, onOrder }) => {
    return (
        <Card>
            <ProductImage src={process.env.REACT_APP_API_ENDPOINT + product.image_path} alt={product.title} />
            <ProductTitle>{product.title}</ProductTitle>
            <ProductDescription>{product.description}</ProductDescription>
            <OrderButton onClick={() => onOrder(product.id)}>Order</OrderButton>
        </Card>
    );
};

export default ProductCard;