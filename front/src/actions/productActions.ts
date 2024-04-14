import { FINISH_ORDER, REMOVE_PRODUCT, SET_PRODUCTS, START_ORDER } from '../types/actions/product/actionProductTypes';
import {
    FinishProductOrderAction,
    RemoveProductAction,
    SetProductsAction,
    StartProductOrderAction
} from '../types/actions/product/actionProductInterfaces';
import {Product} from "../types/Product";

export const setProducts = (products: Product[]): SetProductsAction => ({
    type: SET_PRODUCTS,
    products: products
});

export const startOrder = (productId: number): StartProductOrderAction => ({
    type: START_ORDER,
    productId: productId
});

export const finishOrder = (productId: number): FinishProductOrderAction => ({
    type: FINISH_ORDER,
    productId: productId
});

export const removeProduct = (productId: number): RemoveProductAction => ({
    type: REMOVE_PRODUCT,
    productId: productId
});