import React from "react";
import styled from "styled-components";
function AffichePrice(prix) {
  let affichePrice = String(prix);
  affichePrice =
    affichePrice.substring(0, affichePrice.length - 2) +
    "€" +
    affichePrice.substring(affichePrice.length - 2);
  return affichePrice;
}
function AfficheProduits(p) {
  return (
    <div className="Plats">
      <p>{p["titre"]} </p>
      <span>{AffichePrice(p["prix"])} </span>
    </div>
  );
}

const Carte = (props) => {
  const carte = props.carte;
  const categories = carte["categories"];
  const produits = carte["Plats"];
  console.log(produits);

  return (
    <Wrapper>
      <h1>{carte["title"]}</h1>
      <div className="categories">
        {categories.map((e) => (
          <div className="categorie">
            <h2>{e}</h2>
            {produits.map((p) =>
              p["categories"] === e ? AfficheProduits(p) : null
            )}
          </div>
        ))}
      </div>
      <p class="info">*Tous nos prix sont TTC</p>
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
`;
export default Carte;