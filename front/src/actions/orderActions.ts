import { SET_ORDERING_STATUS } from '../types/actions/order/actionOrderTypes';
import { SetOrderingStatusAction } from '../types/actions/order/actionOrderInterfaces';

export const setOrdering = (isOrdering: boolean): SetOrderingStatusAction => ({
    type: SET_ORDERING_STATUS,
    status: isOrdering
});