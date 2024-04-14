import { OrderActionTypes } from '../types/actions/order/actionOrderInterfaces';
import { SET_ORDERING_STATUS } from '../types/actions/order/actionOrderTypes';

interface OrderingState {
    isOrdering: boolean;
}

const initialState: OrderingState = {
    isOrdering: false
};

export default function orderReducer(state: OrderingState = initialState, action: OrderActionTypes): OrderingState {
    switch (action.type) {
        case SET_ORDERING_STATUS:
            return {
                ...state,
                isOrdering: action.status
            };
        default:
            return state;
    }
}