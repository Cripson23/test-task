import styled, { keyframes } from 'styled-components';

// Анимация вращения
const spin = keyframes`
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
`;

const StyledSmallSpinner = styled.div`
    border: 2px solid ${props => props.theme.colors.primary.regular};
    border-top-color: ${props => props.theme.colors.primary.light};
    border-radius: 50%;
    animation: ${spin} 0.5s linear infinite;
    display: inline-block;

    @media (max-width: 599px) { /* Мобильные */
        width: 20px;
        height: 20px;
    }
    @media (min-width: 600px) and (max-width: 899px) { /* Планшеты */
        width: 15px;
        height: 15px;
    }
    @media (min-width: 900px) { /* Десктопы */
        width: 10px;
        height: 10px;
    }
`;

export default StyledSmallSpinner;