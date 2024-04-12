import styled from 'styled-components';

export const Card = styled.div`
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
`;

export const ProductImage = styled.img`
    width: 100%;
    height: auto;
    object-fit: cover;
    border-radius: 8px;
`;

export const ProductTitle = styled.h2`
    color: ${props => props.theme.colors.dark};
    font-size: ${props => props.theme.fontSizes.medium};
    margin: 10px 0;

    @media (max-width: 599px) {
        font-size: ${props => props.theme.fontSizes.large};
    }
`;

export const ProductDescription = styled.p`
    color: ${props => props.theme.colors.secondary};
    font-size: ${props => props.theme.fontSizes.small};
    text-align: center;

    @media (max-width: 599px) {
        font-size: ${props => props.theme.fontSizes.medium};
    }
`;

export const OrderButton = styled.button`
    background-color: ${props => props.theme.colors.primary.light};
    color: ${props => props.theme.colors.light};
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    margin-top: 15px;
    transition: background-color 0.2s;
    font-size: ${props => props.theme.fontSizes.small};

    &:hover {
        background-color: ${props => props.theme.colors.primary.regular};
    }

    @media (max-width: 599px) {
        font-size: ${props => props.theme.fontSizes.medium};
    }
`;