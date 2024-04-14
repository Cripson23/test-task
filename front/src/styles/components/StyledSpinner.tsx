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

const StyledSpinner = styled.div`
    border: 5px solid ${props => props.theme.colors.primary.regular};
    border-top-color: ${props => props.theme.colors.primary.light};
    border-radius: 50%;
    width: 30px;
    height: 30px;
    animation: ${spin} 1s linear infinite;
`;

// Компонент для спиннера
export default StyledSpinner;