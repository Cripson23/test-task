import { SET_ORDERING_STATUS } from "./actionOrderTypes";

export interface SetOrderingStatusAction {
    type: typeof SET_ORDERING_STATUS;
    status: boolean;
}

export type OrderActionTypes = SetOrderingStatusAction;