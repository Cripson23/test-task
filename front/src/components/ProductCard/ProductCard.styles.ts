import styled, { css } from 'styled-components';

interface CardProps {
    $isSale: boolean;
}

interface ProductPriceProps {
    $isSale: boolean;
}

interface OrderButtonProps {
    $isOrdering: boolean;
    $isOrdered: boolean;
    $isGlobalOrdering: boolean;
}

export const Card = styled.div<CardProps>`
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    margin: 10px;
    width: 300px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: ${props => props.theme.colors.light};

    ${props => props.$isSale && css`
        border-color: ${props => props.theme.colors.success};
        border-width: 3px;
    `};
`;

export const ProductImage = styled.img`
    width: 100%;
    height: auto;
    object-fit: cover;
    border-radius: 8px;
`;

export const ProductTitle = styled.h2`
    color: ${props => props.theme.colors.dark};
    text-align: center;
    margin: 10px 0;

    @media (max-width: 599px) { /* Мобильные устройства */
        font-size: ${props => props.theme.fontSizes.large};
    }
    @media (min-width: 600px) { /* Планшеты и десктоп */
        font-size: ${props => props.theme.fontSizes.medium};
    }
`;

export const ProductSubtitle = styled.h3`
    color: ${props => props.theme.colors.dark};
    text-align: center;
    margin: 0 0 5px;

    @media (max-width: 599px) { /* Мобильные устройства */
        font-size: ${props => props.theme.fontSizes.medium};
    }
    @media (min-width: 600px) { /* Планшеты и десктоп */
        font-size: ${props => props.theme.fontSizes.small};
    }
`;

export const ProductDescription = styled.p`
    color: ${props => props.theme.colors.secondary};
    text-align: center;

    @media (max-width: 599px) { /* Мобильные устройства */
        font-size: ${props => props.theme.fontSizes.medium};
    }
    @media (min-width: 600px) { /* Планшеты и десктоп */
        font-size: ${props => props.theme.fontSizes.small};
    }
`;

export const ProductPrice = styled.p<ProductPriceProps>`
    color: ${props => props.$isSale ? props.theme.colors.success : props.theme.colors.secondary};
    text-align: center;

    @media (max-width: 599px) { /* Мобильные устройства */
        font-size: ${props => props.theme.fontSizes.medium};
    }
    @media (min-width: 600px) { /* Планшеты и десктопы */
        font-size: ${props => props.theme.fontSizes.small};
    }
`;

export const SaleLabel = styled.span`
    color: ${props => props.theme.colors.danger};
    margin-bottom: 5px;
    display: block;

    @media (max-width: 599px) { /* Мобильные устройства */
        font-size: ${props => props.theme.fontSizes.medium};
    }
    @media (min-width: 600px) { /* Планшеты и десктопы */
        font-size: ${props => props.theme.fontSizes.small};
    }
`;

export const OrderButton = styled.button<OrderButtonProps>`
    background-color: ${props => props.$isOrdered
            ? props.theme.colors.dark 
            : (props.$isGlobalOrdering ? props.theme.colors.secondary : props.theme.colors.primary.light)};
    color: ${props => props.theme.colors.light};
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    margin-top: 15px;
    transition: background-color 0.2s;
    font-size: ${props => props.theme.fontSizes.small};
    cursor: ${props => (props.$isGlobalOrdering || props.$isOrdering || props.$isOrdered) ? 'auto' : 'pointer'};
    ${props => !(props.$isGlobalOrdering || props.$isOrdering || props.$isOrdered) && css`
        &:hover {
          background-color: ${props.theme.colors.primary.regular};
        }
    `};
    
    @media (max-width: 599px) { /* Мобильные устройства */
        font-size: ${props => props.theme.fontSizes.large};
    }
    @media (min-width: 600px) and (max-width: 899px) { /* Планшеты */
        font-size: ${props => props.theme.fontSizes.medium};
    }
    @media (min-width: 900px) { /* Десктопы */
        font-size: ${props => props.theme.fontSizes.small};
    }
`;