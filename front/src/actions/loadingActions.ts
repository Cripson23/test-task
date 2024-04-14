import { SET_LOADING } from '../types/actions/loading/actionLoadingTypes';
import { SetLoadingAction } from '../types/actions/loading/actionLoadingInterfaces';

export const setLoading = (isLoading: boolean): SetLoadingAction => ({
    type: SET_LOADING,
    status: isLoading
});