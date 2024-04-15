import axios from 'axios';
import React, { useCallback, useEffect, useState } from 'react';

import { RootState } from "../../store";
import { useDispatch, useSelector } from 'react-redux';
import { setLoading } from '../../actions/loadingActions';
import { finishOrder, removeProduct, setProducts, startOrder } from "../../actions/productActions";
import { setOrdering } from "../../actions/orderActions";

import StyledSpinner from '../../styles/components/StyledSpinner';
import AnimatedOverlay from "../../styles/components/StyledOverlay";
import Popup, { PopupProps } from "../../styles/components/StyledPopup";
import { List } from "./ProductList.styles";
import { Product } from "../../types/Product";
import ProductCard from "./../ProductCard/ProductCard";

interface ApiResponse {
    data: Product[];
}

interface PopupData extends PopupProps {
    show: boolean;
}

const ProductList: React.FC = () => {
    const dispatch = useDispatch();
    const isLoading = useSelector((state: RootState) => state.loading.isLoading);
    const isGlobalOrdering = useSelector((state: RootState) => state.order.isOrdering);
    const products = useSelector((state: RootState) => state.products);

    // Popup settings
    const [popup, setPopup] = useState<PopupData>({
        show: false,
        type: 'message',
        message: '',
        onClose: () => {},
        autoCloseTimeout: undefined
    });

    const closePopup = useCallback(() => {
        setPopup(prev => ({ ...prev, show: false }));
    }, []);

    useEffect(() => {
        setPopup(prev => ({ ...prev, onClose: closePopup }));
    }, [closePopup]);

    useEffect(() => {
        dispatch(setLoading(true));
        axios.post<ApiResponse>(process.env.REACT_APP_API_ENDPOINT + '/products', {})
            .then(response => {
                const timer = setTimeout(() => {  // Добавляем задержку для имитации загрузки
                    if (response.data.data.length === 0) {
                        setPopup(prev => ({ ...prev, show: true, type: 'message', message: 'Товары отсутствуют' }));
                    }
                    dispatch(setProducts(response.data.data));
                    dispatch(setLoading(false));
                }, 2000);
                return () => clearTimeout(timer);
            })
            .catch(error => {
                setPopup(prev => ({ ...prev, show: true, type: 'error', message: 'Ошибка при загрузке товаров' }));
                console.error('Ошибка при загрузке товаров:', error);
                dispatch(setLoading(false));
            });
    }, [closePopup, dispatch]);

    const handleOrder = (isGlobalOrdering: boolean, product: Product) => {
        if (!(isGlobalOrdering || product.isOrdered || product.isOrdering)) {
            if (product.isSoldOut) {
                setPopup(prev => ({
                    ...prev,
                    show: true,
                    type: 'error',
                    message: 'Сожалеем, но данный товар закончился',
                    autoCloseTimeout: 5000
                }));

                return dispatch(removeProduct(product.id));
            }

            if (product.isSale) {
                setPopup(prev => ({
                    ...prev,
                    show: true,
                    type: 'message',
                    message: 'Поздравляем, на этот заказ распространяется скидка!',
                    autoCloseTimeout: 5000
                }));
            }

            dispatch(startOrder(product.id));
            dispatch(setOrdering(true));

            // Имитируем запрос к серверу
            const timer = setTimeout(() => {
                dispatch(finishOrder(product.id));
                dispatch(setOrdering(false));
            }, 2000);
            return () => clearTimeout(timer);
        }
    };

    return (
        <List>
            {popup.show && (
                <Popup
                    message={popup.message}
                    type={popup.type}
                    onClose={popup.onClose}
                    autoCloseTimeout={popup.autoCloseTimeout}
                />
            )}

            <AnimatedOverlay $show={isLoading}>
                <StyledSpinner />
            </AnimatedOverlay>

            { products.map((product: Product) => (
                <ProductCard
                    key={product.id}
                    product={product}
                    onOrder={() => handleOrder(isGlobalOrdering, product)
                } />
            )) }
        </List>
    );
};

export default ProductList;