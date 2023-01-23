import React from "react";
import styled from "styled-components";

const Navigation = () => {
  return (
    <Nav>
      <List>
        <a href="#">
          <Li>Accueil</Li>
        </a>
        <a href="#">
          <Li>Galerie</Li>
        </a>
        <a href="#">
          <Li>Offres</Li>
        </a>
      </List>
    </Nav>
  );
};
const Li = styled.li`
  list-style-type: none;
  font-size: 2vw;
  transition: 0.2s;
  &:hover {
    color: #152028;
  }
`;
const Nav = styled.div`
  margin-top: 10px;
  display: flex;
  flex-direction: row;
  align-items: center;

  a {
    border-radius: 30px;
    padding: 10px;
    text-decoration: none;
  }

  .nav-active {
    background: rgba(255, 255, 255, 0.4);
  }
`;
const List = styled.ul`
  display: flex;
  justify-content: space-around;
  width: 80vw;
  margin: 0;
  padding: 0;
`;
export default Navigation;
