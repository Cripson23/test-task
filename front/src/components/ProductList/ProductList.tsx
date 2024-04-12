import React, { useState, useEffect } from 'react';
import axios from 'axios';

import { List } from "./ProductList.styles";
import { Product } from "../../types/Product";
import ProductCard from "./../ProductCard/ProductCard";

interface ApiResponse {
    data: Product[];
}

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