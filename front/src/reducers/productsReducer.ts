import { Product } from "../types/Product";
import { ProductActionTypes } from "../types/actions/product/actionProductInterfaces";
import { assignRandomFlags, initializeProduct } from "../services/ProductService";

const initialState: Product[] = [];

const productsReducer = (state = initialState, action: ProductActionTypes) => {
    switch (action.type) {
        case 'SET_PRODUCTS':
            let products: Product[] = action.products.map(product => initializeProduct(product));

            if (products.length > 0) {
                products = assignRandomFlags(products);
            }

            return products;
        case 'START_ORDER':
            return state.map(product =>
                product.id === action.productId ? { ...product, isOrdering: true } : product
            );
        case 'FINISH_ORDER':
            return state.map(product =>
                product.id === action.productId ? { ...product, isOrdering: false, isOrdered: true } : product
            );
        case 'REMOVE_PRODUCT':
            return state.filter(product => product.id !== action.productId);
        default:
            return state;
    }
};

export default productsReducer;