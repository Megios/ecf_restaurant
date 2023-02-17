import React from "react";
import styled from "styled-components";
import { devices } from './breackpoint';

function AfficheProduits(p) {
  return (
    <div className="Plats">
      <p className="one">{p["titre"]} </p>
      <span className="two">{p["prix"]} </span>
    </div>
  );
}

const Carte = (props) => {
  const carte = props.carte.Carte;
  const categories = carte["categories"];
  const produits = carte["Plats"];

  return (
    <Wrapper>
      <h1>{carte["title"]}</h1>
      <div className="categories">
        {categories.map((e) => (
          <div className="categorie">
            <h2 className="one">{e}</h2>
            {produits.map((p) =>
              p["categories"] === e ? AfficheProduits(p) : null
            )}
          </div>
        ))}
      </div>
      <p className="info">*Tous nos prix sont TTC</p>
    </Wrapper>
  );
};
const Wrapper = styled.div`
  display: flex;
  flex-direction: column;
  align-items: center;
  background: #b6ac97;
  margin-bottom: 15px;
  border-radius: 10px;
  width: 90vw;
  .Plats {
    display: flex;
    flex-direction: row;
    width: 100%;
    justify-content: space-around;
    align-items: center;
  }
  .categorie {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 45vw;
  }
  .categories {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
  }
  p {
    color: white;
  }
  .info {
    align-self: flex-end;
    margin: 20px;
  }
  .Plats{
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-gap: 10px;
  }
  .one{
    text-align:center;
    grid-column: 1;
    grid-row: 1;
  }
  .two{
    text-align:center;
    grid-column: 2;
    grid-row: 1;
  }
  @media only screen and ${devices.mobile} {
    .categorie{
      width: 80vw;
    }
    
  }
`;
export default Carte;
