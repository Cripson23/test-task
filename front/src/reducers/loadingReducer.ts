import { LoadingActionTypes } from '../types/actions/loading/actionLoadingInterfaces';
import { SET_LOADING } from '../types/actions/loading/actionLoadingTypes';

interface LoadingState {
    isLoading: boolean;
}

const initialState: LoadingState = {
    isLoading: false
};

export default function loadingReducer(state: LoadingState = initialState, action: LoadingActionTypes): LoadingState {
    switch (action.type) {
        case SET_LOADING:
            return {
                ...state,
                isLoading: action.status
            };
        default:
            return state;
    }
}