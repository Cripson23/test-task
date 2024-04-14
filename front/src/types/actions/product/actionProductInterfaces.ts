import { SET_PRODUCTS, START_ORDER, FINISH_ORDER, REMOVE_PRODUCT } from './actionProductTypes';
import { Product } from "../../Product";

export interface SetProductsAction {
    type: typeof SET_PRODUCTS;
    products: Product[];
}

export interface StartProductOrderAction {
    type: typeof START_ORDER;
    productId: number;
}

export interface FinishProductOrderAction {
    type: typeof FINISH_ORDER;
    productId: number;
}

export interface RemoveProductAction {
    type: typeof REMOVE_PRODUCT;
    productId: number;
}

export type ProductActionTypes = SetProductsAction | StartProductOrderAction | FinishProductOrderAction | RemoveProductAction;