import React from 'react';
import { Product } from "../../types/Product";
import {
    Card,
    ProductImage,
    ProductTitle,
    ProductDescription,
    ProductPrice, SaleLabel,
    OrderButton,
    ProductSubtitle
} from "./ProductCard.styles";
import { useSelector } from "react-redux";
import { RootState } from "../../store";
import StyledSmallSpinner from "../../styles/components/StyledSmallSpinner";

interface ProductCardProps {
    product: Product;
    onOrder: (id: number) => void;
}

const defaultProductDetails = { isOrdering: false, isOrdered: false, isSale: false };

const ProductCard: React.FC<ProductCardProps> = ({ product, onOrder }) => {
    const productDetails = useSelector((state: RootState) =>
        state.products.find((p: Product) => p.id === product.id) || defaultProductDetails
    );
    const isGlobalOrdering = useSelector((state: RootState) => state.order.isOrdering);

    return (
        <Card isSale={productDetails.isSale}>
            <ProductImage src={process.env.REACT_APP_API_ENDPOINT + product.image_path} alt={product.title} />
            <ProductTitle>{product.title}</ProductTitle>
            <ProductSubtitle>{product.subtitle}</ProductSubtitle>
            <ProductDescription>{product.description}</ProductDescription>
            <ProductPrice isSale={productDetails.isSale}>{product.price} $</ProductPrice>
            {productDetails.isSale && <SaleLabel>Товар по акции</SaleLabel>}
            <OrderButton
                onClick={() => onOrder(product.id)}
                disabled={productDetails.isOrdering || productDetails.isOrdered}
                isOrdering={productDetails.isOrdering}
                isOrdered={productDetails.isOrdered}
                isGlobalOrdering={isGlobalOrdering}
            >
                {productDetails.isOrdering ? (
                    <StyledSmallSpinner /> // Показываем спиннер
                ) : (
                    productDetails.isOrdered ? 'Уже заказано' : 'Заказать'
                )}
            </OrderButton>
        </Card>
    );
};

export default ProductCard;