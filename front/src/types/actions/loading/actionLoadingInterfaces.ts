import { SET_LOADING } from './actionLoadingTypes';

export interface SetLoadingAction {
    type: typeof SET_LOADING;
    status: boolean;
}

export type LoadingActionTypes = SetLoadingAction;