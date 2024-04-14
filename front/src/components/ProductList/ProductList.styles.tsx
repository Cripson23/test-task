import styled from 'styled-components';

export const List = styled.div`
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 10px;
    gap: 10px;

    /* Стилизация карточек для различных размеров экранов */
    @media (max-width: 599px) { /* Мобильные устройства */
        & > div {
            flex: 0 1 100%;
        }
    }
    @media (min-width: 600px) and (max-width: 899px) { /* Планшеты */
        & > div {
            flex: 0 1 38%;
        }
    }
    @media (min-width: 900px) and (max-width: 1199px) { /* Малые десктопы */
        & > div {
            flex: 0 1 20%;
        }
    }
    @media (min-width: 1200px) { /* Большие десктопы */
        & > div {
            flex: 0 1 15%
        }
    }
`;