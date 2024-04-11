import React, { useState, useEffect } from 'react';
import axios from 'axios';
import styled from 'styled-components';
import ProductCard from "./ProductCard";
import { Product } from "../types/Product";

interface ApiResponse {
    data: Product[];
}

const List = styled.div` 
    /* Стили списка */
`

const ProductList: React.FC = () => {
    const [products, setProducts] = useState<Product[]>([]);

    useEffect(() => {
        const fetchProducts = async () => {
            const response = await axios.post<ApiResponse>(process.env.REACT_APP_API_ENDPOINT + '/products', {});
            const responseData = response.data.data;
            setProducts(responseData);
        };

        fetchProducts();
    }, []);

    return (
        <List>
            {products.map((product) => (
                <ProductCard key={product.id} product={product} onOrder={(id) => console.log(id)} />
            ))}
        </List>
    );
};

export default ProductList;