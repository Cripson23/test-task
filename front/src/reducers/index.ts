import { combineReducers } from 'redux';
import loadingReducer from './loadingReducer';
import productsReducer from './productsReducer';
import orderReducer from './orderReducer';

export const rootReducer = combineReducers({
    loading: loadingReducer,
    order: orderReducer,
    products: productsReducer,
});